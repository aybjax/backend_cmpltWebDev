//cars database
const cars = [
    {
        make: 'Audi',
        model: 'A3',
        year: '2015',
        price: 10000,
        transmission: 'Automatic',
        url: `https://images.pexels.com/photos/2394/lights-clouds-dark-car.jpg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940`
    },
    {
        make: 'Mercedes',
        model: 'B Class',
        year: '2018',
        price: 20000,
        transmission: 'Manual',
        url: `https://images.pexels.com/photos/120049/pexels-photo-120049.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940`
    },
    {
        make: 'Ford',
        model: 'Focus',
        year: '2018',
        price: 13000,
        transmission: 'Manual',
        url: `https://images.pexels.com/photos/1007410/pexels-photo-1007410.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940`
    }
];

const http = require("http");
const url = require("url");

//connection setting
const port = 3000;
const hostname = "127.0.0.1";


//callback fnx: exec'd when request to server

const respond = (req, res) => {
	//console.log(req)};
	const myUrl = req.url=="/" ? "":req.url;

	res.setHeader("Content-Type", "xhuyna/prostoya");
	res.writeHead(200, {"Content-Type":"xhuyna"});

	res.write(`<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>JS Bin</title>
</head>
<body>`);




	//Lektion zwei
	console.log(url.parse(req.url, true).query);
	console.log(url.parse(req.url, true).pathname);
	const query = url.parse(req.url, true).query;
	const path = url.parse(req.url, true).pathname;

	const check = car => (query.make === undefined || query.make.toLowerCase() === car.make.toLowerCase()) &&
		(query.model=== undefined || query.model.toLowerCase() === car.model.toLowerCase())&&
		(query.year === undefined || query.year.toLowerCase() === car.year.toLowerCase()) &&
		(query.transmission === undefined || query.transmission.toLowerCase() === car.transmission.toLowerCase()) &&
		(query.minPrice === undefined || query.minPrice<car.price) &&
		(query.maxPrice === undefined || query.maxPrice>car.price);

	if (path=="/cars"){
		cars.filter(check).forEach(
		car => {
			res.write(`
<hr>
<img src = '${car.url}' height='200' alt='car'>
<p> Make: ${car.make}<p>
<p> Model: ${car.model}<p>
<p> Year: ${car.year}<p>
<p> Transmission: ${car.transmission}<p>
<p> Price: ${car.price}<p>`);
		})
}else{

	res.write("<p>request at url: www.aybjax.com");
	res.write(myUrl);
	res.write(" cannot be accessed");

	res.write(`</body></html>`);
}
	res.end();
};
	

//create server
const server = http.createServer(respond);

//listen to user request: needed for above to run
server.listen(port, hostname, () => {
	console.log(
	`listening from port: ${port}, hostname: ${hostname}\n\n`
	);
});

