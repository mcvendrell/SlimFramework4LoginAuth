/**
 *  Common functions to use
 */

function doLogin() {
  const user = $("#user").val();
  const pass = $("#pass").val();

  if (user === '' || pass === '') {
    alert('Set user and password');
  } else {
    // Prepare form data to send.
    let formData = new FormData();
    formData.append('user', user);
    formData.append('pass', pass);

    fetch('/api/login', {
      method: 'POST',
      body: formData
    }).then(response => {
      if (response.ok) {
        document.location.href = '/addData';
      } else {
        alert('Bad credentials');
      }
    }).catch(error => alert('Error: ', error.message));
  }
}

function addData() {
  const date = $("#date").val();
  const value = $("#value").val();

  if (!date || !value) {
    alert('Fill all fields');
  } else{
    showLoading();

    // Prepare form data to send.
    let formData = new FormData();
    formData.append('date', date);
    formData.append('value', value);

    fetch('/api/records', {
      method: 'POST',
      body: formData
    }).then(response => {
      hideLoading();
      if (response.ok) {
        alert('Data sent');
        $("#date").val('');
        $("#value").val('');
      } else {
        alert('Error in DB');
      }
    }).catch(err => {
      hideLoading();
      alert('Error in API: ' + err.message);
      console.error(err.message);
    });
  }
}