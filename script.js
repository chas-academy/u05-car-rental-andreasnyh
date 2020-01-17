let customerSubmitButton = document.querySelector("input[name='submitCustomer']");
let carSubmitButton = document.querySelector("input[name='submitCar']");

if (customerSubmitButton){
customerSubmitButton.addEventListener("click", function (event) {

    let ssn = document.querySelector("input[name='socialSecurityNumber']");
    let customerName = document.querySelector("input[name='customerName']");
    let phoneNumber = document.querySelector("input[name='phoneNumber']");

    if (validateSSN(ssn.value) === false){
        alert("Please input a valid Swedish Social Security Number!");
        ssn.classList.add("error");
        setTimeout(function () {
            ssn.classList.remove("error")
        },2000);
        event.preventDefault();
    } else if (validateCustomerName(customerName.value) === false){
        alert("Please input Name and Surname");
        customerName.classList.add("error");
        setTimeout(function () {
            customerName.classList.remove("error")
        },2000);
        event.preventDefault();
    }else if (validatePhoneNumber(phoneNumber.value) === false){
        alert("Please input a valid Swedish Phone Number! \n Format : 0XXXXXXXXX");
        phoneNumber.classList.add("error");
        setTimeout(function () {
            phoneNumber.classList.remove("error")
        },2000);
        event.preventDefault();
    }
}, false);
}

if (carSubmitButton){
    carSubmitButton.addEventListener("click", function (event) {

        let registration = document.querySelector("input[name='registration']");
        let year = document.querySelector("input[name='year']");
        let cost = document.querySelector("input[name='cost']");

        if (validateRegistration(registration.value) === false){
            alert("Please input a valid Swedish Registration!");
            registration.classList.add("error");
            setTimeout(function () {
                registration.classList.remove("error")
            },2000);
            event.preventDefault();
        } else if (validateYear(year.value) === false){
            alert("Please input a year between 1900 and 2019");
            year.classList.add("error");
            setTimeout(function () {
                year.classList.remove("error")
            },2000);
            event.preventDefault();
        }else if (validateCost(cost.value) === false){
            alert("Please input Cost with a positive value.");
            cost.classList.add("error");
            setTimeout(function () {
                cost.classList.remove("error")
            },2000);
            event.preventDefault();
        }
    }, false);
}


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

function validateRegistration(reg) {
    //console.log("Raw Phonenumber: " + phoneNumber);
    let regPattern = new RegExp(/[A-HJ-PR-UW-Z][A-HJ-PR-UW-Z][A-HJ-PR-UW-Z]\d\d\d/i);

    // If registration input passes RegExp check
    if (regPattern.test(reg)){
        return true;
    } else {
        return false;
    }
}

function validateYear(year) {
    //console.log("Raw Phonenumber: " + phoneNumber);
    let yearPattern = new RegExp(/(19[0-9]\d|20[01]\d)/);

    // If registration input passes RegExp check
    if (yearPattern.test(year)){
        return true;
    } else {
        return false;
    }
}

function validateCost(cost) {
    //console.log("Raw Phonenumber: " + phoneNumber);
    let costPattern = new RegExp(/^\d*(?:\.)?\d*$/);

    cost = cost.replace(",", ".");
    // If cost input passes RegExp check
    if (costPattern.test(cost)){
        console.log(cost);
        console.log(costPattern.test(cost));
        return true;
    } else {
        return false;
    }
}
