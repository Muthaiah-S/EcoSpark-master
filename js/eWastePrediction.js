document.getElementById('uploadForm').addEventListener('submit', async function(event) {
    event.preventDefault();
    let fileInput = document.getElementById('imageInput').files[0];

    if (!fileInput) {
        alert("Please select an image!");
        return;
    }

    let formData = new FormData();
    formData.append("file", fileInput);

    try {
        let response = await fetch("http://127.0.0.1:5000/predict", {
            method: "POST",
            body: formData
        });

        let data = await response.json();

        console.log("🛠 DEBUG: API Response", data); // Debugging output

        // Update the website with prediction results
        document.getElementById("predictedCategory").innerText = data.category || "Unknown";
        document.getElementById("predictedPrice").innerText = data.price || "N/A";
        document.getElementById("reuseProbability").innerText = data.reuse_probability || "N/A";

    } catch (error) {
        console.error("❌ Error:", error);
        alert("Prediction failed. Check the console for details.");
    }
});