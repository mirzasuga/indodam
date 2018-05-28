let amount = 0.5;
let counter = amount / 86400;
let n = new Date();
n.getHours();
let nd = (n.getHours() * 3600) + (n.getMinutes() * 60);
let res = nd * counter;
let fresult = res;
setInterval(() => {
    fresult += counter;
    console.log(fresult);
},1000);