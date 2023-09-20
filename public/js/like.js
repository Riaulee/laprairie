function onClickButtonLike(event) {
    event.preventDefault();
    console.log('Clicked!');

    const url = this.href;
    const spanCount = document.querySelector('span.js-likes');
    const icone = document.querySelector('i');

    axios.get(url)
        .then(function (response) {
            console.log('response 1');
            console.log(response);

            spanCount.textContent = response.data.likes;

            if (icone.classList.contains('fa-solid')) {
                icone.classList.replace('fa-solid', 'fa-regular')
            } else {
                icone.classList.replace('fa-regular', 'fa-solid')
            }

        })
        .catch(function (error) {
            // en cas d’échec de la requête
            console.log(error);
            if (error.response?.status === 403) {
                window.alert("Vous ne pouvez pas liker un article si vous n'êtes pas connecté")
            }
        })
}

const elements = document.querySelectorAll("a[data-action='like']");
const elementsArray = Array.from(elements);

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll("a[data-action='like']").forEach(function(link){
      link.addEventListener("click", onClickButtonLike);
    });
  });