const dropdownButton = document.getElementById('dropdown-button');
const dropdownMenu = document.getElementById('dropdown-menu');
const dropdownIcon = document.getElementById('dropdown-icon');

dropdownButton.addEventListener('click', () => {
  dropdownMenu.classList.toggle('hidden');
  dropdownIcon.textContent = dropdownIcon.textContent == 'keyboard_arrow_down' ? 'keyboard_arrow_up' : 'keyboard_arrow_down';
});

document.addEventListener('click', (event) => {
  if (!dropdownMenu.contains(event.target) && event.target !== dropdownButton) {
    dropdownMenu.classList.add('hidden');

    dropdownIcon.textContent = 'keyboard_arrow_down';
  }
});