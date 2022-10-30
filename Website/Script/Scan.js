// Section 1
// Script to Add More Input Fields
var AddPersonBtn = document.getElementById('add-person-in-list-btn')
var PeopleDiv = document.getElementById('people-list-div')


//
AddPersonBtn.addEventListener("click", () =>
{
  var NewPersonIF = document.createElement("Input");
  NewPersonIF.setAttribute("type", "text");
  NewPersonIF.setAttribute("placeholder", "Member X");
  NewPersonIF.setAttribute("name", "person-in-list-input");
  NewPersonIF.setAttribute("class", "person-in-list-input");
  NewPersonIF.setAttribute("id", "person-in-list-input");

  PeopleDiv.appendChild(NewPersonIF);
  PeopleDiv.insertBefore(NewPersonIF, AddPersonBtn);
});


// Section 2
// Script to Collect All People Names and add to a Comma Separted String
var SubmitFatoora = document.getElementById('submit-fatoora-scan-btn')
var AllMembersField = document.getElementById('all-members-list')

SubmitFatoora.addEventListener("click", () =>
{
    var PeopleInputFields = Array.from(document.getElementsByClassName('person-in-list-input'))
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
