const execFile = require('child_process').execFile;

    function launchHeadlessChrome(url, callback) {
    // Assuming MacOSx.
    const CHROME = 'google-chrome';
    execFile(CHROME, ['--headless', '--disable-gpu', '--remote-debugging-port=9222', url], callback);
    }

    launchHeadlessChrome('https://www.chromestatus.com', (err, stdout, stderr) => {
        // Do something
    });