
const API_KEY = "Tch0NAfmIoUvMhD8OyuIvJnGGUrV2269";

var searchInput = document.getElementById("address");
var resultsContainer = document.getElementById("address-options");

searchInput.addEventListener("input", function (e) {
      const searchTerm = e.target.value;

      const xhr = new XMLHttpRequest();
      xhr.open("GET", `https://api.tomtom.com/search/2/search/${searchTerm}.json?key=${API_KEY}&limit=5`, true);
      xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                  const searchResults = JSON.parse(xhr.responseText);

                  resultsContainer.innerHTML = "";
                  for (const result of searchResults.results) {
                        const resultOption = document.createElement("option");
                        resultOption.value = result.address.freeformAddress;
                        resultOption.innerText = result.address.freeformAddress;
                        resultsContainer.appendChild(resultOption);
                  }
            }
      };
      xhr.send();
});

resultsContainer.addEventListener("change", function (e) {
      searchInput.value = e.target.value;
});