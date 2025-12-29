<?php
$tickets = getTableData($db, 'learning_tickets', 'date', 'DESC');
?>

<section class="content-section">
    <div class="section-header">
        <h2>🎫 Learning Tickets</h2>
        <button class="btn-add" onclick="openTicketModal()">+ Add Ticket</button>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Ticket #</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><code><?= htmlspecialchars($ticket['ticket_no']) ?></code></td>
                    <td>
                        <?php if ($ticket['image_path']): ?>
                            <img src="../<?= htmlspecialchars($ticket['image_path']) ?>" class="table-thumb">
                        <?php else: ?>
                            <span class="no-image-badge">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($ticket['title']) ?></strong></td>
                    <td><?= truncateText($ticket['description'], 60) ?></td>
                    <td><?= $ticket['date'] ? date('M d, Y', strtotime($ticket['date'])) : '-' ?></td>
                    <td>
                        <span class="badge badge-status-<?= $ticket['status'] ?>">
                            <?= ucfirst($ticket['status']) ?>
                        </span>
                    </td>
                    <td>
                        <button class="btn-icon btn-edit" onclick="editTicket(<?= $ticket['id'] ?>)" title="Edit">✏️</button>
                        <button class="btn-icon btn-delete" onclick="deleteTicket(<?= $ticket['id'] ?>)" title="Delete">🗑️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal -->
<div id="ticketModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeTicketModal()">&times;</span>
        <h3 id="ticketModalTitle">Add Learning Ticket</h3>
        
        <form id="ticketForm" enctype="multipart/form-data">
            <input type="hidden" id="ticketId" name="id">
            
            <div class="form-group">
                <label>Ticket Number: *</label>
                <input type="text" name="ticket_no" required placeholder="LT-2025-001">
            </div>
            
            <div class="form-group">
                <label>Title: *</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" rows="4"></textarea>
            </div>
            
            <div class="form-group">
                <label>Date:</label>
                <input type="date" name="date">
            </div>
            
            <div class="form-group">
                <label>Status:</label>
                <select name="status">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" accept="image/*">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save">Save</button>
                <button type="button" class="btn-cancel" onclick="closeTicketModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<style>
.badge-status-pending {
    background: #fff3cd;
    color: #856404;
}
.badge-status-in_progress {
    background: #cce5ff;
    color: #004085;
}
.badge-status-completed {
    background: #d4edda;
    color: #155724;
}
</style>

<script>
function openTicketModal() {
    document.getElementById('ticketModal').style.display = 'block';
    document.getElementById('ticketModalTitle').textContent = 'Add Learning Ticket';
    document.getElementById('ticketForm').reset();
    document.getElementById('ticketId').value = '';
}

function closeTicketModal() {
    document.getElementById('ticketModal').style.display = 'none';
}

function editTicket(id) {
    fetch(`controllers/tickets.php?action=get&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const ticket = data.data;
                document.getElementById('ticketId').value = ticket.id;
                document.querySelector('[name="ticket_no"]').value = ticket.ticket_no;
                document.querySelector('[name="title"]').value = ticket.title;
                document.querySelector('[name="description"]').value = ticket.description || '';
                document.querySelector('[name="date"]').value = ticket.date || '';
                document.querySelector('[name="status"]').value = ticket.status;
                
                document.getElementById('ticketModalTitle').textContent = 'Edit Ticket';
                document.getElementById('ticketModal').style.display = 'block';
            }
        });
}

function deleteTicket(id) {
    if (!confirm('Delete this ticket?')) return;
    
    fetch('controllers/tickets.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=delete&id=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) location.reload();
        else alert(data.error);
    });
}

document.getElementById('ticketForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    formData.append('action', document.getElementById('ticketId').value ? 'update' : 'create');
    
    const response = await fetch('controllers/tickets.php', {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    if (result.success) location.reload();
    else alert(result.error);
});
</script>