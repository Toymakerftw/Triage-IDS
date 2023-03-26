function toggleDarkMode() {
	var body = document.getElementsByTagName("body")[0];
	body.classList.toggle("dark-mode");

	const toggleSwitch = document.getElementById('dark-mode-toggle');
	const emoji = document.querySelector('.emoji');
  
	if (toggleSwitch.checked) {
	  emoji.innerHTML = '☀️';
	} else {
	  emoji.innerHTML = '🌙';
	}  

}