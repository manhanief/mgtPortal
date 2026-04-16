<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../includes/functions.php';

/**
 * Navigation Controller
 * Handles navigation menu management operations
 */

class NavigationController {
    private static $pdo;

    /**
     * Initialize database connection
     */
    public static function init() {
    $db = getDB();
            if (!$db) {
                throw new Exception("Database connection failed");
            }
            self::$pdo = $db;
    }

    /**
     * Get all navigation items ordered by display_order
     * @return array
     */
    public static function getAllNavigation() {
        $stmt = self::$pdo->query("SELECT * FROM navigation_menu ORDER BY display_order ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update navigation items
     * @param array $data Array of navigation items with id as key
     * @return bool
     */
    public static function handleRequest() {
    $message = '';
    $messageType = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $navigationData = [];

        if (isset($_POST['navigation'])) {
            foreach ($_POST['navigation'] as $id => $item) {
                $navigationData[(int)$id] = [
                    'display_name' => $item['display_name'] ?? '',
                    'is_visible' => isset($item['is_visible']) ? 1 : 0,
                    'display_order' => (int)($item['display_order'] ?? 0)
                ];
            }

            if (self::updateNavigation($navigationData)) {
                $message = 'Navigation settings updated successfully!';
                $messageType = 'success';
            } else {
                $message = 'Failed to update navigation settings.';
                $messageType = 'error';
            }
        }
    }

    $navigationItems = self::getAllNavigation();

    return [
        'navigationItems' => $navigationItems,
        'message' => $message,
        'messageType' => $messageType
    ];
}
    public static function updateNavigation($data) {
        // Validate input
        if (!is_array($data)) {
            return false;
        }

        self::$pdo->beginTransaction();
        try {
            $stmt = self::$pdo->prepare("
                UPDATE navigation_menu
                SET display_name = :display_name,
                    is_visible = :is_visible,
                    display_order = :display_order
                WHERE id = :id
            ");

            foreach ($data as $id => $item) {
                // Validate each item
                if (!isset($item['display_name'], $item['is_visible'], $item['display_order'])) {
                    throw new Exception("Invalid data structure for item ID: $id");
                }

                $displayName = trim($item['display_name']);
                $isVisible = (int)$item['is_visible'];
                $displayOrder = (int)$item['display_order'];

                // Basic validation
                if (empty($displayName) || $displayOrder < 0 || !in_array($isVisible, [0, 1])) {
                    throw new Exception("Invalid data for item ID: $id");
                }

                $stmt->execute([
                    ':display_name' => $displayName,
                    ':is_visible' => $isVisible,
                    ':display_order' => $displayOrder,
                    ':id' => (int)$id
                ]);
            }

            self::$pdo->commit();
            return true;
        } catch (Exception $e) {
            self::$pdo->rollBack();
            error_log("Navigation update error: " . $e->getMessage());
            return false;
        }
    }
}
?>