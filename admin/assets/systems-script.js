function openSystemModal() {
    document.getElementById('systemModal').style.display = 'block';
    document.getElementById('systemModalTitle').textContent = 'Add New System';
    document.getElementById('systemForm').reset();
    document.getElementById('systemId').value = '';
}

function closeSystemModal() {
    document.getElementById('systemModal').style.display = 'none';
}

function editSystem(id) {
    fetch(`handlers/systems-handler.php?action=get&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const system = data.data;
                document.getElementById('systemId').value = system.id;
                document.querySelector('[name="title"]').value = system.title;
                document.querySelector('[name="services"]').value = system.services || '';
                document.querySelector('[name="link_url"]').value = system.link_url || '';
                document.querySelector('[name="display_order"]').value = system.display_order;
                document.querySelector('[name="is_active"]').checked = system.is_active == 1;
                
                document.getElementById('systemModalTitle').textContent = 'Edit System';
                document.getElementById('systemModal').style.display = 'block';
            }
        });
}

function deleteSystem(id) {
    if (!confirm('Delete this system?')) return;
    
    fetch('handlers/systems-handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=delete&id=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error);
        }
    });
}

document.getElementById('systemForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    formData.append('action', document.getElementById('systemId').value ? 'update' : 'create');
    
    const response = await fetch('handlers/systems-handler.php', {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    
    if (result.success) {
        location.reload();
    } else {
        alert(result.error);
    }
});