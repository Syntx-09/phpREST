const login = document.getElementById('login');


login.addEventListener('click', () => {
    
    const formData = new FormData(document.querySelector('form'))
    fetch('http://php-rest.vercel.app:8000/back/login.php', {
        method: 'POST',
        body: formData,
        credentials: 'include'
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
