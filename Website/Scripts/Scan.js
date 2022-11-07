// Section 1
// Script to Add More Input Fields
var AddPersonBtn = document.getElementById('add-person-in-list-btn')
var PeopleDiv = document.getElementById('people-list-div')
window.addEventListener('load',MemberInput)

//
AddPersonBtn.addEventListener("click", MemberInput);

function MemberInput()
{
  var NewPersonDiv = document.createElement("Div");

  NewPersonDiv.setAttribute("class", "person-in-list-input");
  NewPersonDiv.setAttribute("id", "person-in-list-input");


  var NewPersonIF = document.createElement("Input");

  NewPersonIF.setAttribute("type", "text");
  NewPersonIF.setAttribute("placeholder", "Member X");
  NewPersonIF.setAttribute("name", "person-in-list-input-field");
  NewPersonIF.setAttribute("class", "person-in-list-input-field");
  NewPersonIF.setAttribute("id", "person-in-list-input-field");

  NewPersonDiv.appendChild(NewPersonIF);

  var NewPersonIFDel = document.createElement("Input");

  NewPersonIFDel.setAttribute("type", "button");
  NewPersonIFDel.setAttribute("value", "X");
  NewPersonIFDel.setAttribute("name", "person-in-list-input-del");
  NewPersonIFDel.setAttribute("class", "person-in-list-input-del");
  NewPersonIFDel.setAttribute("id", "person-in-list-input-del");

  NewPersonIFDel.addEventListener('click',function(e)
  {
    e.target.parentNode.remove();
  });

  NewPersonDiv.appendChild(NewPersonIFDel);

  PeopleDiv.appendChild(NewPersonDiv);
  PeopleDiv.insertBefore(NewPersonDiv, AddPersonBtn);
}


// Section 2
// Script to Collect All People Names and add to a Comma Separted String
var SubmitFatoora = document.getElementById('submit-fatoora-scan-btn')
var AllMembersField = document.getElementById('all-members-list')

SubmitFatoora.addEventListener("click", () =>
{
    var PeopleInputFields = Array.from(document.getElementsByClassName('person-in-list-input-field'))
    var Members = ""

    PeopleInputFields.forEach((person, i) => {
      if (i == 0)
      {
         Members += person.value
      }
      else
      {
        Members += "," + person.value
      }
    });

    AllMembersField.value = Members

});
