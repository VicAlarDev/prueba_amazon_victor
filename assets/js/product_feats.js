document.addEventListener('DOMContentLoaded', function() {
  // Get all the "more" buttons
  const moreButtons = document.querySelectorAll('.more');

  moreButtons.forEach(button => {
      button.addEventListener('click', function() {
          const icon = this.querySelector('.material-symbols-outlined');
          const text = this.querySelector('p');
          const featContainer = this.closest('tr').nextElementSibling;
          const tdAbsolute = featContainer.querySelector('.td-absolute');
          const featList = featContainer.querySelector('.features');

          // Function to toggle features visibility
          toggleFeatures(icon, text, featContainer, tdAbsolute, featList);
      });
  });
});

function toggleFeatures(icon, text, featContainer, tdAbsolute, featList) {
  icon.textContent = icon.textContent === 'keyboard_arrow_down' ? 'keyboard_arrow_up' : 'keyboard_arrow_down';

  text.textContent = text.textContent === 'Mostrar más' ? 'Mostrar menos' : 'Mostrar más';

  // Toggle classes on features container
  featContainer.classList.toggle('feat-container-empty');
  featContainer.classList.toggle('feat-container');

  // Toggle visibility of content
  tdAbsolute.classList.toggle('none');
  featList.classList.toggle('none');

  // Handle height adjustments and new row insertion
  if (!featContainer.classList.contains('feat-container-empty')) { 
      const featListHeight = featList.offsetHeight + 20; // Add some padding
      tdAbsolute.style.height = featListHeight + 'px';
      featContainer.style.height = featListHeight + 'px';

      // Create and insert a new empty row after the expanded one
      const newRow = document.createElement('tr');
      newRow.classList.add('feat-container-empty');
      featContainer.parentNode.insertBefore(newRow, featContainer.nextSibling);
  } else { // If closing, remove the extra row and reset heights
      tdAbsolute.style.height = '';
      featContainer.style.height = '';
      featContainer.parentNode.removeChild(featContainer.nextSibling);
  }
}
