// Task 4
function fizzBuzz(start, end) {
    for(let num=start; num <= end; num++) {
        if(num % 5 === 0 && num % 3 === 0) {
            console.log("FizzBuzz")
        } else if(num % 3 === 0) {
            console.log("Fizz")
        } else if(num % 5 === 0) {
            console.log("Buzz")
        } else {
            console.log(num)
        }
    }
}

function hawkTuah(start, end) {
    for(let num=start; num <= end; num++) {
        if(num % 5 === 0 && num % 3 === 0) {
            console.log("Hawk Tuah, Spit on that thang!")
        } else if(num % 3 === 0) {
            console.log("Hawk")
        } else if(num % 5 === 0) {
            console.log("Tuah")
        } else {
            console.log(num)
        }
    }
}

fizzBuzz(1,100);
hawkTuah(1,100);