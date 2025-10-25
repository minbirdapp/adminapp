

const toggleSwitch = document.getElementById('toggleSwitch');
    const planPrice = document.getElementById('planPrice');
if(document.getElementById('toggleSwitch')) {
 toggleSwitch.addEventListener('click', () => {
      toggleSwitch.classList.toggle('active');
      if (toggleSwitch.classList.contains('active')) {
        planPrice.textContent = '$90 /year';
      } else {
        planPrice.textContent = '$9 /month';
      }
    });
}
   
    

document.addEventListener("DOMContentLoaded", function () {
                const selectElements = document.querySelectorAll("select");

                selectElements.forEach((select) => {
                    
                    new Choices(select, {
                        allowHTML: true,
                        placeholder: false,
                        shouldSort: false,
                        shouldSortItems: false,
                        searchEnabled: true, // search enable
                        searchPlaceholderValue: "Search...", // search placeholder
                    });
                });
            });