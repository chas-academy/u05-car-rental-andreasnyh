let ssn = document.querySelector("input[name='socialSecurityNumber']");
let submitButton = document.querySelector("input[type='submit'");

ssn.value="Finkar Detta?";

submitButton.addEventListener("click", function (event) {

    if (validateSSN(ssn.value) == false){
        alert("Please input a valid Swedish Social Security Number!");
        event.preventDefault();
    }
}, false);

function validateSSN(ssn) {
    console.log(ssn);
    let ssnPattern = new RegExp(/\d\d[0-1]\d[0-3]\d\d\d\d\d/);
    let digitArray = [];
    //console.log(ssnPattern.test(ssn));
    //console.log(typeof ssn)
    if (ssnPattern.test(ssn)){
        let ssnDigits = ssn.split('');
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
        console.log(digitArrayString.replace(/,/g,""));
        console.log("Valid SSN! " + ssn);
        return true;
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
