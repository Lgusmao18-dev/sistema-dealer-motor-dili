// Admin JS — Dealer Motor Dili

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

// Delete Dealer function (Global - Defined early)
function deleteDealer(id, name) {
    console.log("Delete dealer called for ID:", id, "Name:", name);
    
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Ita-boot serteza?',
            text: "Atu apaga dealer: " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#D32F2F',
            cancelButtonColor: '#333',
            confirmButtonText: 'Sim, Apaga!',
            cancelButtonText: 'Kansela'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log("Deletion confirmed via Swal");
                window.location.href = 'delete_dealer.php?id=' + id;
            }
        });
    } else {
        // Fallback if SweetAlert fails to load
        console.warn("Swal not defined, using fallback confirm");
        if (confirm("Ita-boot serteza atu apaga dealer: " + name + "?")) {
            window.location.href = 'delete_dealer.php?id=' + id;
        }
    }
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const main    = document.getElementById('mainContent');
    if (window.innerWidth <= 992) {
        sidebar.classList.toggle('open');
    } else {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
    }
}

// Navbar scroll shadow
window.addEventListener('scroll', () => {
    const nav = document.querySelector('.top-navbar');
    if (nav) nav.style.boxShadow = window.scrollY > 10 ? '0 2px 12px rgba(0,0,0,.12)' : '0 1px 4px rgba(0,0,0,.08)';
});

// Auto close alert after 4s
document.querySelectorAll('.alert-dismissible').forEach(el => {
    setTimeout(() => {
        const btn = el.querySelector('.btn-close');
        if (btn) btn.click();
    }, 4000);
});

// Global Search Integration with DataTables
document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Dashboard Table if it exists
    if (document.getElementById('recentDealersTable')) {
        $('#recentDealersTable').DataTable({
            dom: 'lrtip', // Hide default search
            paging: false, // Dashboard usually has small limit
            info: false,
            order: [[0, 'desc']]
        });
    }

    // 2. Handle Global Search Input
    const globalSearch = document.getElementById('globalSearch');
    if (globalSearch) {
        globalSearch.addEventListener('input', function() {
            const query = this.value;
            // Target any active DataTable on the page
            if ($.fn.DataTable.isDataTable('#dealersTable')) {
                $('#dealersTable').DataTable().search(query).draw();
            }
            if ($.fn.DataTable.isDataTable('#recentDealersTable')) {
                $('#recentDealersTable').DataTable().search(query).draw();
            }
        });
    }
    // 3. Initialize Dealers Table if it exists
    if (document.getElementById('dealersTable')) {
        const table = $('#dealersTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-PT.json',
                search: "Buka:",
                lengthMenu: "_MENU_",
                info: "Haree dadus _START_ to'o _END_ husi totál _TOTAL_ dadus",
                paginate: {
                    first: "Primeiru",
                    last: "Últimu",
                    next: "Oituan",
                    previous: "Kotuk"
                }
            },
            pageLength: 10,
            responsive: true,
            dom: 'lrtip',
            initComplete: function() {
                // Move length menu to custom container
                $('.dataTables_length').appendTo('#dt-length-container');
            },
            drawCallback: function() {
                $('#dealersTable tbody tr').each(function(i) {
                    setTimeout(() => {
                        $(this).addClass('show');
                    }, i * 100);
                });
            }
        });

        $('#customSearch').on('keyup', function(e) {
            if (e.key === 'Enter') {
                table.search(this.value).draw();
            }
        });

        $('#btnSearch').on('click', function() {
            const query = $('#customSearch').val();
            table.search(query).draw();
        });

        $('#resetSearch').on('click', function(e) {
            e.preventDefault();
            $('#customSearch').val('');
            table.search('').draw();
        });
    }
});
