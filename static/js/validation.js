const submitButton = document.getElementById('submit')
const validColor = "#66B2FF"
const notValidColor = "#FF6666"
let isFieldsValid = {
    y:false,
    r:false
}

function isValidY(yFieldVal) {
    if (isNaN(yFieldVal)) {
        return false
    }
    return yFieldVal >= -3 && yFieldVal <= 5
}

function validateY() {

    let yField = document.getElementById('y')
    yField.style.borderWidth = '2px'
    if (isValidY(parseFloat(yField.value.replace(',', '.')))) {
        yField.style.borderColor = validColor
        isFieldsValid.y = true
        if (isFieldsValid.y && isFieldsValid.r) {
            buttonSwitch(false)
        }
    } else {
        yField.style.borderColor = notValidColor
        buttonSwitch(true)
        isFieldsValid.y = false
    }
}


function isValidR(rFieldVal) {
    if (isNaN(rFieldVal)) {
        return false
    }
    return rFieldVal >= 2 && rFieldVal <= 5
}

function validateR() {
    let rField = document.getElementById('r')
    rField.style.borderWidth = '2px'
    if (isValidR(parseFloat(rField.value.replace(',', '.')))) {
        rField.style.borderColor = validColor
        isFieldsValid.r = true
        if (isFieldsValid.y && isFieldsValid.r) {
            buttonSwitch(false)
        }
    } else {
        rField.style.borderColor = notValidColor
        buttonSwitch(true)
        isFieldsValid.r = false
    }
}

function validateX(chElem) {
    let ind = parseInt(chElem.id)
    for (let i = -3; i <= 5; i++) {
        if (i !== ind) {
            let elem = document.getElementById(i.toString())
            elem.checked = false;
        }
    }
}

function buttonSwitch(disable) {
    if (disable) {
        submitButton.disabled = true;
        submitButton.style.opacity = '0.8'
    } else {
        submitButton.disabled = false;
        submitButton.style.opacity = '1.0'
    }
}