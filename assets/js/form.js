const searchFormElement = document.querySelector('#search-form');
const searchInputElement = searchFormElement.querySelector('input');

searchFormElement.addEventListener('submit', function(event){
    event.preventDefault();
    fetch('/search?search-term='+searchInputElement.value)
            .then(response => response.json())
            .then(data => {
                const listElements = data.reduce((accumulator, article) =>
                        accumulator + `<li><a href="${article.url}">${article.title}</a></li>`, '');
                const resultElement = document.createElement('ul');
                resultElement.innerHTML = listElements;
                searchInputElement.after(resultElement)
            })
});
