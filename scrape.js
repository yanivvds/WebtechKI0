// server.js

const express = require('express');
const { spawn } = require('child_process');
const fs = require('fs');

const app = express();
const port = 3000;

app.use(express.static('public'));

app.post('/runPythonScript', (req, res) => {
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
        runAnotherJavaScriptScript();
    });

    pythonProcess.kill('SIGTERM');
});

function runAnotherJavaScriptScript() {
    const filePath = 'artikel_data.txt';
    const fileContent = fs.readFileSync(filePath, 'utf8');
    const lines = fileContent.split(/\r?\n/);

    const activityData = [];

    for (let i = 0; i < lines.length; i += 3) {
        activityData.push({
            id: String(i / 3 + 1),
            href: lines[i + 1],
            imageUrl: lines[i + 2],
            title: lines[i],
        });
    }

    const responseData = { activityData };

    // Send data to the client using a simple JSON response
    res.json(responseData);

    // Delete the used 'artikel_data.txt' file
    fs.unlink(filePath, (err) => {
        if (err) {
            console.error('Error deleting file:', err);
        } else {
            console.log('File deleted successfully');
        }
    });
}

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
