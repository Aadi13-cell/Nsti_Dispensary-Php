document.getElementById('loginForm').addEventListener('submit', function(event) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username === "" || password === "") {
        alert("Both fields are required.");
        event.preventDefault();
    } else {
        // Simulate login logic, you will handle this in PHP
        // On successful login, redirect to homepage
        // Example: window.location.href = 'home.html';
    }
});

// searchBar cross button------------

    // Get the elements
    const searchInput = document.getElementById('searchInput');
    const clearButton = document.getElementById('clearButton');

    // Show the clear button when there is text
    searchInput.addEventListener('input', function () {
        if (this.value.length > 0) {
            clearButton.style.display = 'inline';
        } else {
            clearButton.style.display = 'none';
        }
    });

    // Clear the input when the clear button is clicked
    clearButton.addEventListener('click', function () {
        searchInput.value = '';
        clearButton.style.display = 'none';
        // Optionally submit the form or reset search results
        document.getElementById('searchForm').submit();  // Submits the form to reset search
    });




// login_ eyes button===

function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.getElementById("eye-icon");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.add("fa-eye");
        eyeIcon.classList.remove("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.add("fa-eye-slash");
        eyeIcon.classList.remove("fa-eye");
    }
}
// ----------------------------------------------------------
// document.querySelector('.search-bar').addEventListener('submit', (e) => {
//     // Form will submit normally and refresh the page to show results
// });

// // If a patient is found, make sure the search result is shown as modal
// if (document.querySelector('.search-result').classList.contains('show')) {
//     document.querySelector('.search-result').style.display = 'block';
// }


document.querySelector('.search-bar').addEventListener('submit', (e) => {
    // Form will submit normally and refresh the page to show results
});

// If a patient is found, make sure the search result is shown as modal
if (document.querySelector('.search-result').classList.contains('show')) {
    document.querySelector('.search-result').style.display = 'block';
}



