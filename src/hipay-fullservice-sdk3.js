/*
 * console.log
 *
 */

(function(a) {
    function b() {}
    for (var c = "assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","), d; !! (d = c.pop());) {
        a[d] = a[d] || b;
    }
})(function() {
    try {
        console.log();
        return window.console;
    } catch(a) {
        return (window.console = {});
    }
} ());

/*
 * ./ console.log
 *
 */


/**
 * dump
 */
function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + " - ";
    }

    alert(out);

    // or, if you wanted to avoid alerts...

    // var pre = document.createElement('pre');
    // pre.innerHTML = out;
    // document.body.appendChild(pre)
}

var _functionExists = function(functionName) {
    return typeof functionName === 'function';
};

var _callFunctionIfExists = function(functionName) {
    return _functionExists(functionName);
};

var _placeholderIsSupported = function() {
    var test = document.createElement('input');
    // alert('placeholder' in test);
    return ('placeholder' in test);
}



var _initPlaceHolderEvent = function(element) {

    if (element.value === _configForm.CREDIT_CARD_NUMBER_PLACEHOLDER) {
        element.style.color = '#636363';
    }



    element.attachEvent("onfocus", function (event) {
        element.style.color = '#000';
        if (element.value === _configForm.CREDIT_CARD_NUMBER_PLACEHOLDER) {
            element.value = '';

        }

        // dump(event.srcElement);
    });

    element.attachEvent("onblur", function (event) {
        if (element.value === "") {
            element.value = _configForm.CREDIT_CARD_NUMBER_PLACEHOLDER;
        }

        if (element.value === _configForm.CREDIT_CARD_NUMBER_PLACEHOLDER) {
            element.style.color = '#636363';
        }

    });

}



var _configForm = {
    'CREDIT_CARD_NUMBER_PLACEHOLDER' : 'Card number'
};

// validator
var _setCaretPosition = function(inputElement, caretPosition) {

    if (inputElement.selectionStart || inputElement.selectionStart === 0) {
        //For all browsers, except IE 8 and earlier
        inputElement.selectionStart = caretPosition;
        inputElement.selectionEnd = caretPosition;
        inputElement.blur(); // Webkit wake-up hack
        inputElement.focus();
    } else if (document.selection) {
        //IE8 and earlier specific code
        inputElement.focus();
        var range = document.selection.createRange();
        range.moveEnd('character', caretPosition - inputElement.value.length); //move 0 characters from current position
        range.select();
    }
};


var _doGetCaretPosition = function(oField) {

    // Initialize
    var iCaretPos = 0;

    // IE Support
    if (document.selection) {

        // Set focus on the element
        oField.focus();

        // To get cursor position, get empty selection range
        var oSel = document.selection.createRange();

        // Move selection start to 0 position
        oSel.moveStart('character', -oField.value.length);

        // The caret position is selection length
        iCaretPos = oSel.text.length;
    }

    // Firefox support
    else if (oField.selectionStart || oField.selectionStart == '0')
        iCaretPos = oField.selectionStart;

    // Return results
    return iCaretPos;
};


var _formatCCInputValue = function(element, caretPosition) {



    // var start = element.selectionStart,
    //     end = element.selectionEnd;


    var regex = /[^0-9 ]/g;
    var matches = element.value.match(regex);
    if (matches && matches.length) {
        caretPosition = caretPosition - matches.length;
        // end = caretPosition - matches.length;
    }


    element.value = (element.value && matches.length > 0) ? element.value.replace(regex, '') : '';
    // restore from variables...
    // element.setSelectionRange(start, end);

    _setCaretPosition(element,caretPosition,matches.length);

};


/**
 * Set the caret position of the given element.
 *
 * @param element
 * @param caretPos
 */
// var _setCaretPosition = function(element, caretPos) {
//     if(element != null) {
//
//         if(element.createTextRange) {
//             var range = element.createTextRange();
//             range.move('character', caretPos);
//             range.select();
//         } else {
//             if(element.selectionStart) {
//                 element.focus();
//                 element.setSelectionRange(caretPos, caretPos);
//             } else {
//                 element.focus();
//             }
//         }
//     }
// };






var _initInputCC = function() {

    // Create input with div
    var divCC = document.getElementById('hipay-input-cc');

    var inputCC = document.createElement("input");

    if (_functionExists(divCC.replaceWith)) {
        divCC.replaceWith(inputCC);
    } else {
        divCC.parentNode.replaceChild(inputCC, divCC);
    }


// create placeholder compatibility with IE
    if (_placeholderIsSupported()) {
        if(_functionExists(inputCC.setAttribute)) {
            inputCC.setAttribute("placeholder", _configForm.CREDIT_CARD_NUMBER_PLACEHOLDER);
        } else {
            inputCC.setAttribute("value", _configForm.CREDIT_CARD_NUMBER_PLACEHOLDER);
            _initPlaceHolderEvent(inputCC);
        }
    } else {
        inputCC.setAttribute("value", _configForm.CREDIT_CARD_NUMBER_PLACEHOLDER);
        _initPlaceHolderEvent(inputCC);
    }


// create data-value

    if(_functionExists(inputCC.setAttribute)) {
        inputCC.setAttribute("data-value", inputCC.value);
    }
    // else {
    //     inputCC.data-value = inputCC.value;
    //
    // }




    if (_functionExists(inputCC.setAttribute)) {
        inputCC.setAttribute("type", "tel");
    } else {



    }


    // inputCC.setAttribute("value", _configForm.CREDIT_CARD_NUMBER_PLACEHOLDER);
    // this.cardNumberInput.attr("maxlength", this.creditCardNumberMask.length);
    // this.cardNumberInput.attr("x-autocompletetype", "cc-number");
    // this.cardNumberInput.attr("autocompletetype", "cc-number");
    // this.cardNumberInput.attr("autocorrect", "off");
    // this.cardNumberInput.attr("spellcheck", "off");
    // this.cardNumberInput.attr("autocapitalize", "off");


    //
    // Events
    //


    // event



    // if (_functionExists(inputCC.addEventListener)) {
    //     inputCC.addEventListener('keydown',function(event){
    //         // event.preventDefault();
    //
    //         alert(inputCC.value + ' ' + event.srcElement.value);
    //         // inputCC.oldValue = inputCC.value;
    //     });
    // } else {
    //     inputCC.attachEvent("onkeydown", function (event) {
    //         // event.preventDefault();
    //     });
    // }


    if (_functionExists(inputCC.addEventListener)) {
        inputCC.addEventListener('keyup',function(event){
            var caretPosition = _doGetCaretPosition(event.srcElement);
            _formatCCInputValue(event.srcElement, caretPosition);
        });
    } else {
        inputCC.attachEvent("onkeyup", function (event) {
            var caretPosition = _doGetCaretPosition(event.srcElement);
            _formatCCInputValue(event.srcElement, caretPosition);
        });
    }



    // inputCC.onkeydownattachEvent("onkeydown", function (event) {
    //     _validateCC(inputCC.value())
    //
    //
    //     alert('toto');
    // });

    // this.cardNumberInput.keydown(function(e) {
    //     CardJs.handleCreditCardNumberKey(e, $this.creditCardNumberMask);
    // });
    // this.cardNumberInput.keyup(function(e) {
    //     $this.refreshCreditCardTypeIcon();
    // });
    // //this.cardNumberInput.change(CardJs.handleCreditCardNumberChange);
    // this.cardNumberInput.on('paste', function() {
    //     setTimeout(function() {
    //         $this.refreshCreditCardNumberFormat();
    //         $this.refreshCreditCardTypeIcon();
    //     }, 1);
    // });
// };


};

(function(){
    _initInputCC();
}())

