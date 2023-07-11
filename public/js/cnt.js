const toastElement = document.getElementById("toast")
const toastBody = document.getElementById("toast-body")

const toast = new bootstrap.Toast(toastElement, {delay: 5000})

htmx.on('htmx:afterRequest', (e) => {
    if (e.detail.failed) {
        let obj = JSON.parse(e.detail.xhr.response)
        toast.show()
        toastBody.innerHTML = "<p class='mb-0'>Une erreure c'est produite !</p> (" + obj.error + ")"
    }
})