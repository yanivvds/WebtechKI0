document.addEventListener("DOMContentLoaded", function () {
    // Get all buttons and content elements
    const saveButtons = document.querySelectorAll(".pin");

    // Add a click event listener to each button
    saveButtons.forEach(function (a) {
        button.addEventListener("click", function () {
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

                const path = 'artikel_data.txt';

                fs.access(path, fs.constants.F_OK, (err) => {
                    if (err) {
                        console.log("de python files is nog niet aangemaakt");
                    } else {
                        const fs = require('fs');

                        const filePath = 'artikel_data.txt';

                        // Read the entire file into memory
                        const fileContent = fs.readFileSync(filePath, 'utf8');

                        // Split the content into an array of lines
                        const lines = fileContent.split(/\r?\n/);
                        // hier moet de html code aangepast worden of gegenereerd worden
                        console.log(lines)
                    }
                });

                pythonProcess.on('close', (code) => {
                    console.log(`Python script exited with code ${code}`);
                    res.status(200).send(`Python script exited with code ${code}`);
                });

                pythonProcess.kill('SIGTERM');


            // Delete used txt files

            // Delete the file
            fs.unlink(path, (err) => {
                if (err) {
                    console.error('Error deleting file:', err);
                } else {
                    console.log('File deleted successfully');
                }
            });
            const pad = 'locatie.txt';
            fs.unlink(path, (err) => {
                if (err) {
                    console.error('Error deleting file:', err);
                } else {
                    console.log('File deleted successfully');
                }
            });
        });
    });
});})