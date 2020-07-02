//subprocess
const {execSync} = require('child_process');

const calculateSize = (abspath, type, stats) => {
    let size;
    let byte;
    const units = "BKMGT";
    //for directory
    if(type==="dir"){
        const cleanPath = abspath.replace(/\s/g, "\ ");
        size = execSync(`du -sh "${cleanPath}"`).toString()
        size = size.replace(/\s/g, "");
        size =  size.split("/")[0];
        
        //change unit to bytes
        //unit letter
        const unit = size.replace(/\d|\./g, "").toUpperCase();
        //nbr part
        byte = parseFloat(size.replace(/[a-z]/i, ""));

        /*  B -> *1000^0 - index
            K -> *1000^1
            M -> *1000^2 ... */
        byte = byte*Math.pow(1024, units.indexOf(unit));
    } else if (type==="file"){
        byte = stats.size;
        const index = Math.floor(Math.log(byte)/Math.log(1024));
        size = (byte/Math.pow(1024, index)).toFixed(1) + units[index];
    }
    return [size, byte];
}

module.exports=calculateSize;