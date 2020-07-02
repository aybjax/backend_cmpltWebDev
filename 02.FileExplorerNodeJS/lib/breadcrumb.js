const path = require("path");
const breadcrumb = pathname => {
    const pathChunks = pathname.split("/").filter(el => el !== "");
    let breadcrumb = `<li class="breadcrumb-item"><a href="/">Home</a></li>`;
    let link = "/";
    pathChunks.forEach((item, index) => {
        if (index !== pathChunks.length-1){
            link = path.join(link, item);
            breadcrumb += `<li class="breadcrumb-item"><a href="${link}">${item}</a><li>`;
        } else {
            link = path.join(link, item);
            breadcrumb += `<li class="breadcrumb-item active"><a href="${link}">${item}</a><li>`;
        }
    })

    return breadcrumb
}
module.exports = breadcrumb;