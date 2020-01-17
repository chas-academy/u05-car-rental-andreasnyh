// Andréas Ny 2020

// Get submit buttons from Add Customer/Edit Customer
// and Add Car/Edit Car
let customerSubmitButton = document.querySelector("input[name='submitCustomer']");
let carSubmitButton = document.querySelector("input[name='submitCar']");

// If customerSubmitButton exists (not NULL) add an click event
if (customerSubmitButton){
customerSubmitButton.addEventListener("click", function (event) {

    // The input fields we want to validate
    let ssn = document.querySelector("input[name='socialSecurityNumber']");
    let customerName = document.querySelector("input[name='customerName']");
    let phoneNumber = document.querySelector("input[name='phoneNumber']");

    // If the value of the input-field doesn't pass the validation
    // Display an alert and Add/remove .error class
    if (validateSSN(ssn.value) === false){
        alert("Please input a valid Swedish Social Security Number!");
        ssn.classList.add("error");
        setTimeout(function () {
            ssn.classList.remove("error")
        },2500);
        // .preventDefault Makes it so the forms don't get submitted if they fail validation
        event.preventDefault();
    } else if (validateCustomerName(customerName.value) === false){
        alert("Please input Name and Surname");
        customerName.classList.add("error");
        setTimeout(function () {
            customerName.classList.remove("error")
        },2500);
        event.preventDefault();
    }else if (validatePhoneNumber(phoneNumber.value) === false){
        alert("Please input a valid Swedish Phone Number! \n Format : 0XXXXXXXXX");
        phoneNumber.classList.add("error");
        setTimeout(function () {
            phoneNumber.classList.remove("error")
        },2500);
        event.preventDefault();
    }
}, false);
}

// If carSubmitButton exists (not NULL) add an click event
if (carSubmitButton){
    carSubmitButton.addEventListener("click", function (event) {

        // The input fields we want to validate
        let registration = document.querySelector("input[name='registration']");
        let year = document.querySelector("input[name='year']");
        let cost = document.querySelector("input[name='cost']");

        // If the value of the input-field doesn't pass the validation
        // Display an alert and Add/remove .error class
        if (validateRegistration(registration.value) === false){
            alert("Please input a valid Swedish Registration!");
            registration.classList.add("error");
            setTimeout(function () {
                registration.classList.remove("error")
            },2500);
            // .preventDefault Makes it so the forms don't get submitted if they fail validation
            event.preventDefault();
        } else if (validateYear(year.value) === false){
            alert("Please input a year between 1900 and 2019");
            year.classList.add("error");
            setTimeout(function () {
                year.classList.remove("error")
            },2500);
            event.preventDefault();
        }else if (validateCost(cost.value) === false){
            alert("Please input Cost with a positive value.");
            cost.classList.add("error");
            setTimeout(function () {
                cost.classList.remove("error")
            },2500);
            event.preventDefault();
        }
    }, false);
}


function validateSSN(ssn) {
    //console.log("Raw SSN: " + ssn);
    // RegExp Pattern to validate string with
                        // (/start\0-9\0-9\0-1\0-9\0-3\0-9\0-9\0-9\0-9\0-9\end/)
    let ssnPattern = new RegExp(/^\d\d[0-1]\d[0-3]\d\d\d\d\d$/);
    let digitArray = [];
    let ssnDigits = ssn.split(''); // Split string into an array of individual digits

    // If SSN input passes RegExp check
    if (ssnPattern.test(ssn)){

        // Loop through the first 9 numbers (not the last validation digit)
        for (let i = 0; i < 9; i++){
            if (i % 2 == 0) {
                digitArray.push(ssnDigits[i] * 2); // if it's an even number push (number*2) to digitArray
            } else {
                digitArray.push(ssnDigits[i] * 1); // if it's an odd number push (number*1) to digitArray
            }
        }

        // turn digitArray back to a string
        let digitArrayString = digitArray.toString();

        // Replace all "," from array->string conversion with nothing
        digitArrayString = digitArrayString.replace(/,/g,"");
        //console.log("digitArrayString: " + digitArrayString);

        // Take each digit and make an array
        let singleDigitArray = digitArrayString.split("");
        //console.log("singleDigitArray: " + singleDigitArray);

        // Join every digit in the array with a + sign between each digit => sum of all the digits
        let sum = eval(singleDigitArray.join('+'));
        //console.log("sum: " + sum);

        // Calculate control digit
        let controlNumber = Number(10 - (sum % 10) % 10);
        //console.log("controlNumber: " + controlNumber);


        // If last digit of input equals calculated control number
        // Return True == pass validation
        // Else return False == last digit is not valid
        if (parseInt(ssnDigits[9]) === controlNumber) {
            //console.log("Valid SSN! " + ssn);
            //console.log(ssnDigits[9] +" === "+ controlNumber);
            return true;
        } else {
            //console.log("Invalid SSN! " + ssn);
            //console.log(ssnDigits[9] +" === "+ controlNumber);
            return false;
        }

    } else {// If ssn don't pass RegExp.test => Return False
        //console.log("Invalid SSN!")
        return false;
    }

}

function validateCustomerName(customerName) {
    // start\word\'space'\word
    let namePattern = new RegExp(/^\w+\s+\w*/);

    // If name input passes RegExp check
    if (namePattern.test(customerName)){
        return true;
    } else {
        return false;
    }
}

function validatePhoneNumber(phoneNumber) {
    //0 followed by 9 digits
    let phonePattern = new RegExp(/[0]\d\d\d\d\d\d\d\d\d/);

    // If phone input passes RegExp check
    if (phonePattern.test(phoneNumber)){
        return true;
    } else {
        return false;
    }
}

function validateRegistration(reg) {
    // Pattern for car registration 3xletters\3xdigits
    let regPattern = new RegExp(/[A-HJ-PR-UW-Z][A-HJ-PR-UW-Z][A-HJ-PR-UW-Z]\d\d\d/i);

    // If registration input passes RegExp check
    if (regPattern.test(reg)){
        return true;
    } else {
        return false;
    }
}

function validateYear(year) {
    // 19\digit\digit OR 20\0-1\digit
    let yearPattern = new RegExp(/(19\d\d|20[01]\d)/);

    // If year input passes RegExp check
    if (yearPattern.test(year)){
        return true;
    } else {
        return false;
    }
}

function validateCost(cost) {
    // start\digit*?(maybe a '.')\digit*?\end
    let costPattern = new RegExp(/^\d*(?:\.)?\d*$/);

    cost = cost.replace(",", ".");

    // If cost input passes RegExp check
    if (costPattern.test(cost)){
        return true;
    } else {
        return false;
    }
}
