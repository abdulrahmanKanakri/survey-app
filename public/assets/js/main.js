// In Answering Page //
let optionsRadio = document.querySelectorAll("input[type='radio']");
if(optionsRadio) {
    optionsRadio.forEach(option => {
        option.addEventListener('change', () => {
            let textareaOther = document.getElementById('textarea-other');
            if(textareaOther) {
                if(option.value == "other") {
                    textareaOther.classList.remove('d-none');
                } else {
                    textareaOther.classList.add('d-none');
                    textareaOther.value = '';
                }
            }
        });
    });
}

// Get question info
let questionDataInput = document.querySelector('#answering-page form input[name="question_data"]');
let questionDataInfo;
if(questionDataInput) {
    questionDataInfo = JSON.parse(questionDataInput.value);
    questionDataInput.remove();
}

let nextBtn = document.getElementById('next-btn');
let backBtn = document.getElementById('back-btn');
if(nextBtn) {
    nextBtn.onclick = () => {
        
        // Validation Answering Form
        let formInAnsweringPage = document.getElementById('question-form');
        
        // Validate if the user removes the required inputs
        let manyInputs = document.querySelector('input[name="question[answers][]"]');
        let oneInput = document.querySelector('input[name="question[answer]"]');
        let oneTextarea = document.querySelector('textarea[name="question[answer]"]');

        if(!manyInputs && !oneInput && !oneTextarea) {
            showAlertWithTimer('error', 'Please do not miss<br>I will refresh in');
            return;
        }

        // Validate the question is required
        let flag = false;
        Array.from(formInAnsweringPage.elements).forEach(elem => {
            if(elem.type == 'radio' || elem.type == 'checkbox') {
                if(elem.checked && elem.value != 'other') {
                    flag = true;
                }
            } else if(
                // this to allow input hidden like _token & _method
                elem.type != 'hidden' &&
                // this to prevent user send only white spaces
                elem.value.replace(/\s/g, '').length > 0
            ) {
                flag = true;
            }
        });

        if(flag) {
            formInAnsweringPage.submit();
        } else {
            showAlert('warning', 'This question is required');
        }
    }
}
if(backBtn) {
    backBtn.onclick = () => {
        document.getElementById('back-form').submit();
    }
}

// In Start Survey Page //
// Validation
let formInStartPage = document.querySelector('#start-page form');
if(formInStartPage) {
    formInStartPage.onsubmit = (e) => {
        e.preventDefault();
        if(
            !formInStartPage['user[email]'] || 
            !formInStartPage['user[username]'] || 
            !formInStartPage['user[phone_number]']
        ) {
            showAlertWithTimer('error', 'Please do not miss<br>I will refresh in');
        } else if(
            formInStartPage['user[email]'].value == "" ||
            formInStartPage['user[username]'].value == "" ||
            formInStartPage['user[phone_number]'].value == ""
        ) {
            showAlert('warning', 'This information is required');
        } else {
            formInStartPage.submit();
        }
    }
}
