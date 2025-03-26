const toggleButton = document.getElementById('toggle-btn');
const sidebar = document.getElementById('sidebar');
function togglesidebar() {
    sidebar.classList.toggle('close');
    toggleButton.classList.toggle('rotate');
}
function togglesubMenu(button) {
    const menu = document.querySelector('.sub-menu');
    const icon = button.querySelector('i');

    button.nextElementSibling.classList.toggle('show');
    button.classList.toggle('rotate');
}