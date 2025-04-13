// get reference to element containing checkboxContainPrice checkboxes
var el = document.getElementById('checkboxContainPrice');

// get reference to input elements in checkboxContainPrice container element
var tops = el.getElementsByTagName('input');

// assign function to onclick property of each checkbox
// for (var i=0, len=tops.length; i<len; i++) {
//     if ( tops[i].type === 'checkbox' ) {
//         tops[i].onclick = function() {
//             // put your awesome code here
//             alert('this tis working')
//         }
//     }
// }

// call onload or in script segment below form
function attachCheckboxHandlers() {
    // get reference to element containing checkboxContainPrice checkboxes
    var el = document.getElementById('checkboxContainPrice');

    // get reference to input elements in checkboxContainPrice container element
    var tops = el.getElementsByTagName('input');

    // assign updateTotal function to onclick property of each checkbox
    for (var i=0, len=tops.length; i<len; i++) {
        if ( tops[i].type === 'checkbox' ) {
            tops[i].onclick = updateTotal;
        }
    }
}

// called onclick of checkboxContainPrice checkboxes
function updateTotal(e) {
    // 'this' is reference to checkbox clicked on
    var form = this.form;

    // get current value in total text box, using parseFloat since it is a string
    var val = parseFloat( form.elements['total'].value );

    // if check box is checked, add its value to val, otherwise subtract it
    if ( this.checked ) {
        val += parseFloat(this.value);
    } else {
        val -= parseFloat(this.value);
    }

    // format val with correct number of decimal places
    // and use it to update value of total text box
    form.elements['total'].value = formatDecimal(val);
}

// format val to n number of decimal places
// modified version of Danny Goodman's (JS Bible)
function formatDecimal(val, n) {
    n = n || 2;
    var str = "" + Math.round ( parseFloat(val) * Math.pow(10, n) );
    while (str.length <= n) {
        str = "0" + str;
    }
    var pt = str.length - n;
    return str.slice(0,pt) + "." + str.slice(pt);
}

// in script segment below form
attachCheckboxHandlers();