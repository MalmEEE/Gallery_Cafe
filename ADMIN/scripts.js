//-----------------------Login check------------------------
document.addEventListener('DOMContentLoaded', () => {
    fetchOrders();

    const orderForm = document.getElementById('orderForm');
    const orderModal = document.getElementById('orderModal');
    const modalTitle = document.getElementById('modalTitle');
    const submitButton = document.getElementById('submitButton');
    const closeModal = document.getElementsByClassName('close')[0];

    // Fetch orders from the server
    function fetchOrders() {
        fetch('manage_orders.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    window.location.href = 'login.html';
                    return;
                }

                const tableBody = document.getElementById('orderTableBody');
                tableBody.innerHTML = '';
                data.forEach(order => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${order.id}</td>
                        <td>${order.name}</td>
                        <td>${order.email}</td>
                        <td>${order.phone}</td>
                        <td>${order.product}</td>
                        <td>${order.quantity}</td>
                        <td>${order.pre_order_date}</td>
                        <td>${order.pre_order_time}</td>
                        <td>${order.notes}</td>
                        <td>
                            <button class="edit-btn" data-id="${order.id}">Edit</button>
                            <button class="delete-btn" data-id="${order.id}">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.getAttribute('data-id');
                        fetch(`manage_orders.php?id=${id}`)
                            .then(response => response.json())
                            .then(data => {
                                modalTitle.textContent = 'Edit Order';
                                submitButton.textContent = 'Update Order';
                                orderForm['id'].value = data.id;
                                orderForm['name'].value = data.name;
                                orderForm['email'].value = data.email;
                                orderForm['phone'].value = data.phone;
                                orderForm['product'].value = data.product;
                                orderForm['quantity'].value = data.quantity;
                                orderForm['pre_order_date'].value = data.pre_order_date;
                                orderForm['pre_order_time'].value = data.pre_order_time;
                                orderForm['notes'].value = data.notes;
                                orderModal.style.display = 'block';
                            });
                    });
                });

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.getAttribute('data-id');
                        if (confirm('Are you sure you want to delete this order?')) {
                            fetch(`manage_orders.php?delete&id=${id}`)
                                .then(response => response.text())
                                .then(data => {
                                    alert(data);
                                    fetchOrders();
                                });
                        }
                    });
                });
            });
    }

    // Open modal for adding new order
    document.getElementById('addOrderBtn').addEventListener('click', () => {
        modalTitle.textContent = 'Add Order';
        submitButton.textContent = 'Add Order';
        orderForm.reset();
        orderForm['id'].value = '';
        orderModal.style.display = 'block';
    });

    // Close modal
    closeModal.addEventListener('click', () => {
        orderModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === orderModal) {
            orderModal.style.display = 'none';
        }
    });
});


//-------------------Manage Reservations--------------------

document.addEventListener('DOMContentLoaded', () => {
    fetchReservations();

    const reservationForm = document.getElementById('reservationForm');
    const reservationModal = document.getElementById('reservationModal');
    const modalTitle = document.getElementById('modalTitle');
    const submitButton = document.getElementById('submitButton');
    const closeModal = document.getElementsByClassName('close')[0];

    // Fetch reservations from the server
    function fetchReservations() {
        fetch('manage_reservations.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('reservationTableBody');
                tableBody.innerHTML = '';
                data.forEach(reservation => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${reservation.id}</td>
                        <td>${reservation.name}</td>
                        <td>${reservation.email}</td>
                        <td>${reservation.phone}</td>
                        <td>${reservation.date}</td>
                        <td>${reservation.time}</td>
                        <td>${reservation.guests}</td>
                        <td>
                            <button class="edit-btn" data-id="${reservation.id}">Edit</button>
                            <button class="delete-btn" data-id="${reservation.id}">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
                attachEventListeners();
            });
    }

    // Attach event listeners to Edit and Delete buttons
    function attachEventListeners() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                fetch(`manage_reservations.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        modalTitle.textContent = 'Edit Reservation';
                        submitButton.textContent = 'Update Reservation';
                        reservationForm['id'].value = data.id;
                        reservationForm['name'].value = data.name;
                        reservationForm['email'].value = data.email;
                        reservationForm['phone'].value = data.phone;
                        reservationForm['date'].value = data.date;
                        reservationForm['time'].value = data.time;
                        reservationForm['guests'].value = data.guests;
                        reservationModal.style.display = 'block';
                    });
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', () => {
                if (confirm('Are you sure you want to delete this reservation?')) {
                    const id = button.getAttribute('data-id');
                    fetch(`manage_reservations.php?delete=1&id=${id}`)
                        .then(response => response.text())
                        .then(() => {
                            fetchReservations();
                        });
                }
            });
        });
    }

    // Handle form submission
    reservationForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(reservationForm);
        fetch('manage_reservations.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(() => {
                reservationModal.style.display = 'none';
                fetchReservations();
            });
    });

    // Open modal to add reservation
    document.getElementById('addReservationBtn').addEventListener('click', () => {
        modalTitle.textContent = 'Add Reservation';
        submitButton.textContent = 'Add Reservation';
        reservationForm.reset();
        reservationForm['id'].value = '';
        reservationModal.style.display = 'block';
    });

    // Close modal
    closeModal.addEventListener('click', () => {
        reservationModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === reservationModal) {
            reservationModal.style.display = 'none';
        }
    });
});



//-------------------------Manage Pre-Orders-------------------------------
document.addEventListener('DOMContentLoaded', () => {
    fetchOrders();

    const orderForm = document.getElementById('orderForm');
    const orderModal = document.getElementById('orderModal');
    const modalTitle = document.getElementById('modalTitle');
    const submitButton = document.getElementById('submitButton');
    const closeModal = document.getElementsByClassName('close')[0];

    // Fetch orders from the server
    function fetchOrders() {
        fetch('manage_orders.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('orderTableBody');
                tableBody.innerHTML = '';
                data.forEach(order => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${order.id}</td>
                        <td>${order.name}</td>
                        <td>${order.email}</td>
                        <td>${order.phone}</td>
                        <td>${order.product}</td>
                        <td>${order.quantity}</td>
                        <td>${order.pre_order_date}</td>
                        <td>${order.pre_order_time}</td>
                        <td>${order.notes}</td>
                        <td>
                            <button class="edit-btn" data-id="${order.id}">Edit</button>
                            <button class="delete-btn" data-id="${order.id}">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
                attachEventListeners();
            });
    }

    // Attach event listeners to Edit and Delete buttons
    function attachEventListeners() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                fetch(`manage_orders.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        modalTitle.textContent = 'Edit Order';
                        submitButton.textContent = 'Update Order';
                        orderForm['id'].value = data.id;
                        orderForm['name'].value = data.name;
                        orderForm['email'].value = data.email;
                        orderForm['phone'].value = data.phone;
                        orderForm['product'].value = data.product;
                        orderForm['quantity'].value = data.quantity;
                        orderForm['pre_order_date'].value = data.pre_order_date;
                        orderForm['pre_order_time'].value = data.pre_order_time;
                        orderForm['notes'].value = data.notes;
                        orderModal.style.display = 'block';
                    });
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this order?')) {
                    fetch(`manage_orders.php?delete&id=${id}`)
                        .then(response => response.text())
                        .then(data => {
                            alert(data);
                            fetchOrders();
                        });
                }
            });
        });
    }

    // Open modal for adding new order
    document.getElementById('addOrderBtn').addEventListener('click', () => {
        modalTitle.textContent = 'Add Order';
        submitButton.textContent = 'Add Order';
        orderForm.reset();
        orderForm['id'].value = '';
        orderModal.style.display = 'block';
    });

    // Close modal
    closeModal.addEventListener('click', () => {
        orderModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === orderModal) {
            orderModal.style.display = 'none';
        }
    });
});







