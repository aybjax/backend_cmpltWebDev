const path = require("path");
const url = require('url');
const fs = require('fs');
const breadCrumbBuild = require('./breadcrumb');
const buildContent = require('./maincontent');
const getMime = require('./getmimetype');


//static folder is home folder
const staticBasePath = path.join(__dirname, "..", "static");

//servers respond
const respond = (request, response) => {
    const serverUrl = request.url;
    let pathName = url.parse(serverUrl, true).pathname;

    //two paths. '/flavincon.ico' is dismissed
    if (pathName === '/favicon.ico'){
        console.log("flavicon removed");
        return false;
    }

    //get readable path
    pathName = decodeURIComponent(pathName);

    //join this path to static folder path
    pathLongName = path.join(staticBasePath, pathName);

    //see if the path corresponds to real
    if (!fs.existsSync(pathLongName)){
        response.write("<h1>404: file not found</h1>");
        console.log(`${pathLongName} does not exit`);
        return false;
    }// else {
    //     response.write("<h1>file exits");
    //     console.log(`${pathLongName} exits`);
    // }

    let stats;
    try{
        stats=fs.lstatSync(pathLongName);
    }catch(err){
        console.log(`lstatSync error: ${err}`)
    }
    
    //is Directory
    if (stats.isDirectory()){
        console.log("path is directory");
        //get content of index html
        let data=fs.readFileSync(path.join(staticBasePath, 'project_files/index.html'), 'utf-8');

        //page title
        let pageTitles = pathName.split("/").reverse();
        pageTitles = pageTitles.filter(el => el !== "")[0];
        if(pageTitles===undefined){
            pageTitles = "Home"
        }
        

        //modify breadvrumb
        const breadcrumb = breadCrumbBuild(pathName);        

        //main content recursion and building it
        const main_content = buildContent(pathLongName, pathName);

        //loading data to index.html
        data = data.replace("page title", pageTitles);
        data = data.replace("pathname", breadcrumb);
        data = data.replace("main_content", main_content);
        response.statusCode=200;
        response.write(data);
        console.log("index.html is written to response");
        return response.end();
    } else if (!stats.isFile()){
        response.statusCode = 401;
        response.write(`<h1> 401: Access denied!</h1>`);
        console.log("not a file");
        return response.end();
    } else {
        const fileObj = {}

        //get file extension
        fileObj.ext = path.extname(pathName);

        //get mime type and add it into response header
        getMime(fileObj.ext)
        .then(mime => {
            console.log(mime);

            //store headers
            let head = {};
            let option = {};
            //response status code
            let statusCode = 200;
            //set content-type
            head["Content-Type"] = mime;

            //special extensions
            if (fileObj.ext===".pdf"){
                head['Content-Disposition'] = 'inline';

                //to download
                //head['Content-Disposition'] = 'attachment;filename=learn to code.pdf';
            }

            if (RegExp("audio").test(mime) || RegExp("video").test(mime)){
                head['Accept-Ranges'] = 'bytes';
                const range = request.headers.range;
                console.log(`range: ${range}`);

                //if range is defined => unless continue as usual
                if (range){
                    let stat;
                    try{
                        stat = fs.statSync(pathLongName);
                    } catch (err) {
                        console.log(`Error: ${err}`);
                    }

                    //bytes=st-end
                    let st_end = range.replace(/bytes=/, "").split("-");

                    const st = parseInt(st_end[0]);
                    const end = st_end[1] ? parseInt(st_end[1]) : stat.size-1;
                    //bc it starts from 0

                    //headers
                    //Content-range
                    head["Content-Range"] = `bytes ${st}-${end}/${stat.size}`;
                    //content length
                    head["Content-Length"] = end-st+1;
                    statusCode = 206;
                    option = {st, end};
                    console.log(head);
                    console.log(`        start: ${st}
        end: ${end}
        range: ${end-st+1}
        filesize: ${stat.size}`);
                }
            }

            //readfile
            /*fs.readFile(pathLongName, 'utf-8', (err, data) =>{
                if(err){
                    response.statusCode=404;
                    response.write(`<div>404:File reading error`);
                    return response.end();
                }else{
                    response.writeHead(statusCode, head);
                    response.write(data);
                    return response.end();
                }
            });*/

            const fileStream = fs.createReadStream(pathLongName, option);

            response.writeHead(statusCode, head);
            //stream response obj
            fileStream.pipe(response);

            //events of filesstream
            fileStream.on('close', ()=>{
                return response.end();
            })

            fileStream.on("error", err => {
                response.statusCode=404;
                response.write(`<div>404:File streaming error`);
                return response.end();
            })
        })
        .catch(err => {
            stats.statusCode=500;
            response.write(`<h1>500: Internal Server Error</h1>`);
            console.log(`getMime promise error ${err}`);
            return response.end();
        })




    }
}

module.exports = respond;