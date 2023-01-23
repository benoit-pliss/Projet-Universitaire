document
  .querySelector(["select[name='formationSelect']"])
  .addEventListener("change", (e) => {
    fillTab(e.target.value);
  });

function fillTab(formationID) {
  fetch(
    "https://dev-sae301grp1.users.info.unicaen.fr/romaindev/ajax/getFormationStudents.php?formationId=" +
      formationID
  )
    .then((response) => response.json())
    .then((students) => {
      [
        ...document
          .querySelector("tbody[name='students']")
          .querySelectorAll("tr"),
      ].forEach((tr) => tr.remove());

      Object.values(students).forEach((student) => {
        let tr = document.createElement("tr");
        tr.classList.add("hover");
        tr.innerHTML = `<td>${student.studentName}</td><td>
      <div tabindex="0" class="collapse collapse-arrow border border-base-300 bg-base-100 rounded-box" style="visibility: visible;">
          <div class="collapse-title text-xl font-medium">
              Compétence(s)
          </div>
          <div class="collapse-content" name="skill">`;
        fetch(
          "https://dev-sae301grp1.users.info.unicaen.fr/romaindev/ajax/getFormationSkills.php?formationId=" +
            formationID
        )
          .then((response) => response.json())
          .then((skills) => {
            Object.values(skills).forEach((skill) => {
              let div = document.createElement("div");
              div.innerHTML = `<div tabindex="0" class="collapse collapse-arrow border border-base-300 bg-base-100 rounded-box" style="visibility: visible;">
                  <div class="collapse-title text-xl font-medium" name="skillTitle">
                      ${skill.skillName}
                  </div>
                  <div class="collapse-content" name="aptitude">`;
              fetch(
                "https://dev-sae301grp1.users.info.unicaen.fr/romaindev/ajax/getSkillAptitudes.php?skillId=" +
                  skill.skillId
              )
                .then((response) => response.json())
                .then((aptitudes) => {
                  let completed = 0;
                  let current = 0;
                  let total = 0;

                  Promise.all(
                    Object.values(aptitudes).map((aptitude) =>
                      fetch(
                        "https://dev-sae301grp1.users.info.unicaen.fr/romaindev/ajax/getAptitudeStatus.php?aptitudeId=" +
                          aptitude.aptitudeId +
                          "&studentId=" +
                          student.studentId
                      )
                        .then((response) => response.json())
                        .then((status) => {
                          if (status.length > 0) {
                            console.log(status[0].statusId);
                            switch (status[0].statusId) {
                              case "3":
                                console.log("Current++");
                                current++;
                                break;
                              case "4":
                                console.log("Completed++");
                                completed++;
                                break;
                            }
                            let p = document.createElement("p");
                            p.innerHTML = `${aptitude.aptitudeName} ➡ ${
                              status[0].statusName
                            } ${getEmoji(status[0].statusId)}`;
                            div
                              .querySelector("div[name='aptitude']")
                              .appendChild(p);
                          } else {
                            let p = document.createElement("p");
                            p.innerHTML = `${aptitude.aptitudeName}`;
                            div
                              .querySelector("div[name='aptitude']")
                              .appendChild(p);
                          }
                        })
                    )
                  ).then(() => {
                    total = Object.values(aptitudes).length;
                    console.log(
                      "Completed" + completed,
                      "Current" + current,
                      "Total" + total
                    );
                    if (completed == total) {
                      div.querySelector(
                        "div[name='skillTitle']"
                      ).innerHTML += ` - Terminé ✅`;
                    } else if (current > 0 || completed > 0) {
                      div.querySelector(
                        "div[name='skillTitle']"
                      ).innerHTML += ` - En cours ⌛`;
                    } else {
                      div.querySelector(
                        "div[name='skillTitle']"
                      ).innerHTML += ` - Non commencé ❌`;
                    }
                  });
                })
                .catch((error) => {
                  console.error("Error:", error);
                });
              div.innerHTML += `</div></div>`;
              tr.querySelector("div[name='skill']").appendChild(div);
            });
          })
          .catch((error) => {
            console.error("Error:", error);
          });
        tr.innerHTML += `</div></div>
      </td>`;
        document.querySelector("tbody[name='students']").appendChild(tr);
      });
    });
}

function getEmoji(statusId) {
  switch (statusId) {
    case "1":
      return "❌";
    case "2":
      return "🕐";
    case "3":
      return "⌛";
    case "4":
      return "✅";
  }
}

fillTab(1);
