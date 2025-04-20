const form = document.querySelector('form');
form.addEventListener('submit', function (event) {
    event.preventDefault();
});

$("#sbt-btn").click(function () {
    const email = $("#mail").val();
    const password = $("#password").val();
    let data = `mail=${email}&password=${password}`;
    console.log(data);
    $.ajax({
        type: 'POST',
        url: '../php/UserLogin.php',
        data: {mail:email,password:password},
        success: function (response) {
            // Parse the JSON response
            const data = response;
            console.log(response);
            if (data.status === 'success') {
                let fname = encodeURIComponent(data.fname);
                let lname = encodeURIComponent(data.lname);
                let id = encodeURIComponent(email);
                // Redirect to Users.html with query parameters
                window.location.href = '../Users.html?fname=' + fname + '&lname=' + lname + '&id=' + id;
            } else {
                document.getElementById('result').innerHTML = "Invalid User ID or Password";
            }
        },
        error: function (xhr, status, error) {
            // Handle AJAX errors here
            console.log(xhr.responseText);
            console.error('AJAX error:', status, error);
            document.getElementById('result').innerHTML = "An error occurred. Please try again.";
        }
    });
});
