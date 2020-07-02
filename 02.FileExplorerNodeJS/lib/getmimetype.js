const https = require('https');

//mimetype json file url
const mimeURL = `https://gist.githubusercontent.com/AshHeskes/6038140/raw/27c8b1e28ce4c3aff0c0d8d3d7dbcb099a22c889/file-extension-to-mime-types.json`;

const getMime = ext => {
    return new Promise((resolve, reject) => {
        https.get(mimeURL, response => {
            //reject Promise if status code is not 200-299
            if(response.statsCode <200 || response.statsCode >299){
                reject(`Error: failed to load mime types json file: ${response.statsCode}`);
                console.log(`Error: failed to load mime types json file: ${response.statsCode}`)
                //so that code stops
                return false;
            }

            let data="";

            //data received as chunks
            response.on('data', chunk => {
                data += chunk;
            })

            //when all data is received
            response.on('end', () =>{
                resolve(JSON.parse(data)[ext]);
        })
        }).on('error', err => {
            console.log(`Error: https.get failure: ${err}`);
        })
    })
}

module.exports = getMime;