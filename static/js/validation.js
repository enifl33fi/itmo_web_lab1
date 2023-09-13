const submitButton = document.getElementById('submit')
const validColor = "#66B2FF"
const notValidColor = "#FF6666"
let isFieldsValid = {
    y:false,
    r:false
}
const RegEx = /^-?\d+([.,]\d+)?$/

function isValidY(yFieldVal) {
    if (!RegEx.test(yFieldVal)) {
        return false
    }
    return yFieldVal >= -3 && yFieldVal <= 5
}

function validateY() {
    let yField = document.getElementById('y')
    yField.style.borderWidth = '2px'
    if (isValidY(yField.value.replace(',', '.'))) {
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
    if (!RegEx.test(rFieldVal)) {
        return false
    }
    return rFieldVal >= 2 && rFieldVal <= 5
}

function validateR() {
    let rField = document.getElementById('r')
    rField.style.borderWidth = '2px'
    if (isValidR(rField.value.replace(',', '.'))) {
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
    let checkboxes = document.getElementsByName("x[]")
    for (const elem of checkboxes) {
        elem.checked = false;
    }
    chElem.checked = true;
}

function buttonSwitch(disable) {
    if (disable) {
        submitButton.disabled = true;
        submitButton.classList.remove('shown')
        submitButton.classList.add('hidden')
    } else {
        submitButton.disabled = false;
        submitButton.classList.remove('hidden')
        submitButton.classList.add('shown')
    }
}