const fs=require('fs');
const path=require('path');
const calculateSize=require('./calculateSize')
const folderIcon = "folder-open-sharp";
const fileIcon = "document";
const html = `<tr data-name="nomisi" data-size="kolembyte" data-mod="Unix-time">
<td><a href="link"><ion-icon name="belgi"></ion-icon>nomisi</a></td>
<td>kolem</td>
<td>vaqit</td>
</tr>`
// const beforeLink = "<tr><td><a href='";
// const beforeIcon = "'><ion-icon name='";
// const beforeName = "'></ion-icon>";
// const beforeSize = "</a></td><td>";
// const beforeModification = "</td><td>";
// const endi = "</td></tr>";


const main_content = (abspath, relpath) => {
    let mainContent = "";
    
    let content
    //looping in directory
    try{
        content = fs.readdirSync(abspath);
        console.log(content);
    } catch(err){
        console.log(`readdirSync Error: {err}`);
        return `<div class="alert alert-danger">Internal Server Error</div>`
    }

    content = content.filter(el => el[0]!==".");

    //home directory remove sourcefile
    if(relpath==="/"){
        content = content.filter(el => el !== "project_files");
    }
    content.forEach(item => {
        //create object instead of creating global variables
        const itemObj = {};

        //find link for it
        itemObj.link = path.join(relpath, item);
        itemObj.tag = html.replace("link", itemObj.link);
        itemObj.tag = itemObj.tag.replace(/nomisi/g, item);
        
        //choose correct icon
        itemObj.itemPath = path.join(abspath, item);
        
        //get stats for item
        try{
            itemObj.stats = fs.statSync(itemObj.itemPath);
        }catch(err){
            console.log(`fs.statSync Error: ${err}`);
            mainContent = `<div class="alert alert-danger">Internal Server Error</div>`;
            return false;
        }

        //is directory
        if(itemObj.stats.isDirectory()){
            //refresh icon
            itemObj.tag = itemObj.tag.replace("belgi", folderIcon);
            
            //get the size of it
            [itemObj.size, itemObj.bytes]  = calculateSize(path.join(abspath, item), "dir");
        }else if(itemObj.stats.isFile()){
            //refresh icon
            itemObj.tag = itemObj.tag.replace("belgi", fileIcon);
            
            //get the size of it
            [itemObj.size, itemObj.bytes]  = calculateSize(path.join(abspath, item), "file", itemObj.stats);
            itemObj.tag = itemObj.tag.replace(`a href="`, `a target="blank" href="`);
        }

        //timestamp
        itemObj.timeStamp = parseInt(itemObj.stats.mtimeMs);
        itemObj.time = new Date(itemObj.timeStamp);
        itemObj.time = itemObj.time.toLocaleString();
        
        itemObj.tag = itemObj.tag.replace("kolembyte", itemObj.bytes);
        itemObj.tag = itemObj.tag.replace("kolem", itemObj.size);
        itemObj.tag = itemObj.tag.replace("Unix-time", itemObj.timeStamp);
        itemObj.tag = itemObj.tag.replace("vaqit", itemObj.time);

        mainContent += itemObj.tag;
    })
    return mainContent;
}

module.exports = main_content;