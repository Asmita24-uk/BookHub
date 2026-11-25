function searchBooks() {

    let search = document.getElementById("search").value;

    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {

        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("results").innerHTML = xhr.responseText;
        }

    };

    xhr.open("GET", "search_books.php?search=" + search, true);
    xhr.send();
}