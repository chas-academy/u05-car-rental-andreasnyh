let ssn = document.querySelector("input[name='socialSecurityNumber']");
let submitButton = document.querySelector("input[type='submit'");

ssn.value="8711151616";

submitButton.addEventListener("click", function (event) {

    if (validateSSN(ssn.value) == false){
        alert("Please input a valid Swedish Social Security Number!");
        event.preventDefault();
    }
}, false);

function validateSSN(ssn) {
    console.log("Raw SSN: " + ssn);
    let ssnPattern = new RegExp(/\d\d[0-1]\d[0-3]\d\d\d\d\d/);
    let digitArray = [];
    let ssnDigits = ssn.split('');
    //console.log(ssnPattern.test(ssn));
    //console.log(typeof ssn)
    if (ssnPattern.test(ssn)){

        for (let i = 0; i < 9; i++){
            if (i % 2 == 0) {
                digitArray.push(ssnDigits[i] * 2);
            } else {
                digitArray.push(ssnDigits[i] * 1);
            }
            //console.log(ssnSplit[i]);
        }
        console.log(digitArray);
        let digitArrayString = digitArray.toString();
        // Replace all "," with nothing
        digitArrayString = digitArrayString.replace(/,/g,"");
        console.log("digitArrayString: " + digitArrayString);
        // Take each digit and make an array
        let singleDigitArray = digitArrayString.split("");
        console.log("singleDigitArray: " + singleDigitArray);
        // Join every digit in the array with a + sign between each digit = sum of all the digits
        let sum = eval(singleDigitArray.join('+'));
        console.log("sum: " + sum);

        let controllNumber = Number(10 - (sum % 10) % 10);
        console.log("controllNumber: " + controllNumber);



        if (parseInt(ssnDigits[9]) === controllNumber) {
            console.log("Valid SSN! " + ssn);
            console.log(ssnDigits[9] +" === "+ controllNumber);
            return true;
        } else {
            console.log("Invalid SSN! " + ssn);
            console.log(ssnDigits[9] +" === "+ controllNumber);
            return false;
        }

    } else {
        console.log("Invalid SSN!")
        return false;
    }

}

/*
document.querySelector("#id-checkbox").addEventListener("click", function(event) {
    document.getElementById("output-box").innerHTML += "Sorry! <code>preventDefault()</code> won't let you check this!<br>";
    event.preventDefault();
}, false);*/
