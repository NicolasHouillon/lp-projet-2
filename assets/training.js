let submitFormButton = document.getElementById('submitFormButton')
submitFormButton.addEventListener('click', (e) => {
    e.preventDefault()
    console.log("hey")
    const form = document.getElementById('subject_form')
    console.log(form)
})