document.addEventListener("DOMContentLoaded", function () {
    // Get all buttons and content elements
    const saveButtons = document.querySelectorAll(".pin");

    // Add a click event listener to each button
    saveButtons.forEach(function (a) {
        a.addEventListener("click", function () {
            // Get the target content ID from the button's data attribute
            const targetContentId = a.dataset.target;

            // Find the content element based on the target content ID
            const contentToSave = document.querySelector(`[data-content-id="${targetContentId}"]`);

            // Get the content from the HTML tag
            const content = contentToSave.innerHTML;

            // Save content to localStorage (you can modify this to use sessionStorage or other methods)
            const fs = require('fs')
 
            // Write data in 'Output.txt' .
            fs.writeFile('locatie.txt', content, (err) => {
 
            // In case of a error throw err.
            if (err) throw err;
            })

            const express = require('express');
            const { spawn } = require('child_process');

            // Create an instance of the Express application
            const app = express();

            // Set the port number for the server to listen on
            const port = 3000;

            // Serve static files from the 'public' directory
            app.use(express.static('public'));

            // Define a route to handle POST requests to '/runPythonScript'
            app.post('/runPythonScript', (res) => {
                // Spawn a new process to run the Python script
                const pythonProcess = spawn('python', ['scraper.py']);

                pythonProcess.stdout.on('data', (data) => {
                    console.log(`Python script output: ${data}`);
                });
            
                pythonProcess.stderr.on('data', (data) => {
                    console.error(`Error in Python script: ${data}`);
                });

                pythonProcess.on('close', (code) => {
                    console.log(`Python script exited with code ${code}`);
                    res.status(200).send(`Python script exited with code ${code}`);

                    // After the Python script has completed, run another JavaScript script
                    runAnotherJavaScriptScript();
                });

                pythonProcess.kill('SIGTERM');
                
            
        });
    });
});})

function runAnotherJavaScriptScript() {
    // Add your code here to run another JavaScript script
    const fs = require('fs');

    const filePath = 'artikel_data.txt';

    // Read the entire file into memory
    const fileContent = fs.readFileSync(filePath, 'utf8');

    // Split the content into an array of lines
    const lines = fileContent.split(/\r?\n/);

    // Loop through activity containers and update content
    for (let i = 1; i <= 10; i++) {
        const activityContainer = document.getElementById(String(i));

        if (activityContainer) {
            // Update href attribute
            activityContainer.querySelector('a').href = lines[i * 3 - 2];

            // Update background-image URL
            activityContainer.querySelector('.activity-offer').style.backgroundImage = `url("${lines[i * 3 - 1]}")`;

            // Update h2 text content
            activityContainer.querySelector('.activity-title').innerText = lines[i * 3 - 3];
        }
    }

    // Delete the used 'artikel_data.txt' file
    fs.unlink(filePath, (err) => {
        if (err) {
            console.error('Error deleting file:', err);
        } else {
            console.log('File deleted successfully');
        }
    });
}




// Delete used txt files

// Delete the file

const pad = 'locatie.txt';
fs.unlink(pad, (err) => {
    if (err) {
        console.error('Error deleting file:', err);
    } else {
        console.log('File deleted successfully');
    }
});
