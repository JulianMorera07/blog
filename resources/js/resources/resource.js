import 'jquery';
import $ from 'jquery';
$(document).ready(function () {
    $('#registerForm').on('submit', function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.post('/api/create-register', formData)
            .done(function (response) {
                alert('User registered successfully.');
                window.location.href = '/login'; // Redirect to login page
            })
            .fail(function (xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            });
    });

    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.post('/api/sign-in', formData)
            .done(function (response) {
                alert('Login successful.');
                localStorage.setItem('token', response.token); // Store the token
                alert('Tu token de ingreso es: '+response.token);
                window.location.href = '/';
            })
            .fail(function (xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            });
    });
});
