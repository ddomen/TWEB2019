const INVALID_CLASS = 'app-invalid';
const EMAIL_REGEX = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
const NAME_REGEX = /^[a-zA-Z \']{3,150}$/;
const USERNAME_REGEX = /^[a-zA-Z0-9]{3,20}$/;
const FLOAT_REGEX = /^[0-9]+[,]{0,1}[0-9]*$/;

function validateBase($target, callback, errClass = INVALID_CLASS){
    if(typeof callback == 'function'){
        $target.on('change', ()=>{
            if(callback.call($target, $target.val())){ $target.removeClass(errClass); }
            else{ $target.addClass(errClass); }
        });
        $target.on('blur', ()=>{
            if(callback.call($target, $target.val())){ $target.removeClass(errClass); }
            else{ $target.addClass(errClass); }
        });
    }
    return $target;
}

function validateRequired($target, errClass = INVALID_CLASS){ return validateBase($target, (value) => value != '' && value !== undefined, errClass); }

function validateInt($target, errClass = INVALID_CLASS){ return validateBase($target, (value) => value.match(/^\d+/), errClass); }

function validateNumber($target, errClass = INVALID_CLASS){ return validateBase($target, (value) => FLOAT_REGEX.test(value), errClass); }

function validateEmail($target, errClass = INVALID_CLASS){ return validateBase($target, (value) => EMAIL_REGEX.test(value), errClass); }

function validateDate($target, errClass = INVALID_CLASS){ return validateBase($target, (value) => true, errClass); }

function validateName($target, errClass = INVALID_CLASS){ return validateBase($target, (value) => NAME_REGEX.test(value), errClass); }

function validateUsername($target, errClass = INVALID_CLASS){ return validateBase($target, (value) => USERNAME_REGEX.test(value), errClass); }

function validate($target, options){
    let errClass = options.class;
    if(options.required){ validateRequired($target, errClass); }
    switch(options.type){
        case 'int': case 'integer': validateInt($target, errClass); break;
        case 'float': case 'number': validateNumber($target, errClass); break;
        case 'email': validateEmail($target, errClass); break;
        case 'date': validateDate($target, errClass); break;
        case 'name': validateName($target, errClass); break;
        case 'username': validateUsername($target, errClass); break;
        default: case 'custom': if(typeof options.callback == 'function'){ validateBase($target, options.callback, errClass); } break;
    }
    return $target;
}


$(document).ready(()=>{
    $('.validation.required').each(function(){ validateRequired($(this)); });
    $('.validation.integer').each(function(){ validateInt($(this)); });
    $('.validation.number').each(function(){ validateNumber($(this)); });
    $('.validation.email').each(function(){ validateEmail($(this)); });
    $('.validation.date').each(function(){ validateDate($(this)); });
    $('.validation.name').each(function(){ validateName($(this)); });
    $('.validation.username').each(function(){ validateUsername($(this)); });
    $('form').submit(function(evt){
        if($(this).find('.' + INVALID_CLASS).length !== 0){
            evt.preventDefault();
            window.alert('Alcuni campi sono incorretti!')
        }
    })
})