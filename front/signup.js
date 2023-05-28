const signup = document.getElementById('signup');
var status;


signup.addEventListener('click', () => {
    const formData = new FormData(document.querySelector('form'))
    fetch('http://localhost:8000/signup.php', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        status = res.status
        return res.text()
    })
    .then(data => {
        alert(data)
        if (status == 200)
        location.href = "./index.html"
    })
    .catch(err => { alert(err) })
})


