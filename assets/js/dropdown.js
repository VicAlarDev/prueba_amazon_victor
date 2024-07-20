document.addEventListener('DOMContentLoaded', function () {
  const dropdownButton = document.getElementById('dropdown-button');
  const dropdownMenu = document.getElementById('dropdown-menu');
  const dropdownIcon = document.getElementById('dropdown-icon');
  let isMenuOpen = false;

  dropdownButton.addEventListener('click', function () {
    isMenuOpen = !isMenuOpen; // Toggle menu state

    if (isMenuOpen) {
      dropdownMenu.style.display = 'block';
      dropdownIcon.textContent = 'keyboard_arrow_up'; // Change arrow icon
    } else {
      dropdownMenu.style.display = 'none';
      dropdownIcon.textContent = 'keyboard_arrow_down';
    }
  });

  // Close the dropdown if the user clicks outside of it
  document.addEventListener('click', function (event) {
    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
      dropdownMenu.style.display = 'none';
      isMenuOpen = false;
      dropdownIcon.textContent = 'keyboard_arrow_down';
    }
  });
});

