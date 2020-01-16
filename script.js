
let ssn = document.querySelector("input[name='socialSecurityNumber']");
let customerName = document.querySelector("input[name='customerName']");
let phoneNumber = document.querySelector("input[name='phoneNumber']");

let customerSubmitButton = document.querySelector("input[name='submitCustomer']");


customerSubmitButton.addEventListener("click", function (event) {

    if (validateSSN(ssn.value) === false){
        alert("Please input a valid Swedish Social Security Number!");
        event.preventDefault();
    } else if (validateCustomerName(customerName.value) === false){
        alert("Please input Name and Surname");
        event.preventDefault();
    }else if (validatePhoneNumber(phoneNumber.value) === false){
        alert("Please input a valid Swedish Phone Number! \n Format : 0XXXXXXXXX");
        event.preventDefault();
    }
}, false);

/*
function validateForms(event) {
    let ssn = document.querySelector("input[name='socialSecurityNumber']");
    let customerName = document.querySelector("input[name='customerName']");
    let phoneNumber = document.querySelector("input[name='phoneNumber']");
    alert(event);
    event.preventDefault();
    if (validateSSN(ssn.value) === false){
        alert("Please input a valid Swedish Social Security Number!");
        event.preventDefault();
    } else if (validateCustomerName(customerName.value) === false){
        alert("Please input Name and Surname");
        event.preventDefault();
    }else if (validatePhoneNumber(phoneNumber.value) === false){
        alert("Please input a valid Swedish Phone Number! \n Format : 0XXXXXXXXX");
        event.preventDefault();
    }
}
*/
function validateSSN(ssn) {
    //let ssn = document.querySelector("input[name='socialSecurityNumber']");
    console.log("Raw SSN: " + ssn);
    let ssnPattern = new RegExp(/\d\d[0-1]\d[0-3]\d\d\d\d\d/);
    let digitArray = [];
    let ssnDigits = ssn.split('');

    // If SSN input passes RegExp check
    if (ssnPattern.test(ssn)){

        for (let i = 0; i < 9; i++){
            if (i % 2 == 0) {
                digitArray.push(ssnDigits[i] * 2);
            } else {
                digitArray.push(ssnDigits[i] * 1);
            }
            //console.log(ssnSplit[i]);
        }
        //console.log(digitArray);
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

        let controlNumber = Number(10 - (sum % 10) % 10);
        console.log("controlNumber: " + controlNumber);


        // If last digit of input equals calculated control number
        if (parseInt(ssnDigits[9]) === controlNumber) {
            console.log("Valid SSN! " + ssn);
            console.log(ssnDigits[9] +" === "+ controlNumber);
            return true;
        } else {
            console.log("Invalid SSN! " + ssn);
            console.log(ssnDigits[9] +" === "+ controlNumber);
            return false;
        }

    } else {
        console.log("Invalid SSN!")
        return false;
    }

}

function validateCustomerName(customerName) {
    //console.log("Raw Phonenumber: " + phoneNumber);
    let namePattern = new RegExp(/^\w+\s+\w*/);

    // If phone input passes RegExp check
    if (namePattern.test(customerName)){
        return true;
    } else {
        return false;
    }
}

function validatePhoneNumber(phoneNumber) {
    //console.log("Raw Phonenumber: " + phoneNumber);
    let phonePattern = new RegExp(/[0]\d\d\d\d\d\d\d\d\d/);

    // If phone input passes RegExp check
    if (phonePattern.test(phoneNumber)){
        return true;
    } else {
        return false;
    }
}

/*
document.querySelector("#id-checkbox").addEventListener("click", function(event) {
    document.getElementById("output-box").innerHTML += "Sorry! <code>preventDefault()</code> won't let you check this!<br>";
    event.preventDefault();
}, false);*/
