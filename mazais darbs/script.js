document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("uploadFileBtn").addEventListener("click", function () {
        showSection("uploadFileSection");
    });

    document.getElementById("deleteFileBtn").addEventListener("click", function () {
        showSection("deleteFileSection");
    });

    function showSection(sectionId) {
        document.getElementById("uploadFileSection").style.display = "none";
        document.getElementById("deleteFileSection").style.display = "none";
        document.getElementById(sectionId).style.display = "block";
    }

    // Change label text when a file is selected
    const fileInput = document.getElementById("fileInput");
    const fileLabel = document.getElementById("fileLabel");

    fileInput.addEventListener("change", function () {
        if (fileInput.files.length > 0) {
            fileLabel.textContent = fileInput.files[0].name;
        } else {
            fileLabel.textContent = "No file selected";
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("uploadFileBtn").addEventListener("click", function () {
        showSection("uploadFileSection");
    });

    document.getElementById("displayFilesBtn").addEventListener("click", function () {
        showSection("displayFilesSection");
        fetchFiles();
    });

    document.getElementById("deleteFileBtn").addEventListener("click", function () {
        showSection("deleteFileSection");
    });

    function showSection(sectionId) {
        document.getElementById("uploadFileSection").style.display = "none";
        document.getElementById("displayFilesSection").style.display = "none";
        document.getElementById("deleteFileSection").style.display = "none";
        document.getElementById(sectionId).style.display = "block";
    }

function fetchFiles() {
    fetch('fetch_files.php?t=' + new Date().getTime()) // Appending timestamp to URL to prevent caching
        .then(response => response.text())
        .then(data => {
            document.getElementById("filesList").innerHTML = data;
        })
        .catch(error => console.error("Error fetching files:", error));
}

    
    
});

function deleteFile(fileId) {
    if (confirm("Are you sure you want to delete this file?")) {
        fetch('delete_file.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'fileId=' + fileId
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show success or error message

            if (data.includes("✅")) { // Check if the response indicates a successful delete
                // Remove the file card from the page instantly without refreshing everything
                const fileCard = document.getElementById("file-" + fileId);
                if (fileCard) fileCard.remove();
            }
        })
        .catch(error => console.error('Error deleting file:', error));
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("fileInput");
    const fileLabel = document.getElementById("fileLabel");

    fileInput.addEventListener("change", function () {
        if (fileInput.files.length > 0) {
            fileLabel.textContent = fileInput.files[0].name;
        } else {
            fileLabel.textContent = "No file selected";
        }
    });
});