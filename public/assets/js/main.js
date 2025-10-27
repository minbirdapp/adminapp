const toggleSwitch = document.getElementById("toggleSwitch");
const planPrice = document.getElementById("planPrice");
if (document.getElementById("toggleSwitch")) {
    toggleSwitch.addEventListener("click", () => {
        toggleSwitch.classList.toggle("active");
        if (toggleSwitch.classList.contains("active")) {
            planPrice.textContent = "$90 /year";
        } else {
            planPrice.textContent = "$9 /month";
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const selectElements = document.querySelectorAll("select");
    selectElements.forEach((select) => {
        new Choices(select, {
            allowHTML: true,
            placeholder: false,
            shouldSort: false,
            shouldSortItems: false,
            searchEnabled: true, // search enable
            searchPlaceholderValue: "Search...", // search placeholder
        });
    });
});

if (document.getElementById("reportChart")) {
    const ctx = document.getElementById("reportChart").getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
            datasets: [
                {
                    label: "Posts",
                    data: [12, 19, 3, 5, 2, 3, 9],
                    borderColor: "rgba(111, 66, 193, 1)",
                    tension: 0.3,
                    fill: true,
                    backgroundColor: "rgba(111, 66, 193, 0.1)",
                },
                {
                    label: "Accounts",
                    data: [4, 15, 6, 8, 10, 7, 11],
                    borderColor: "rgba(0, 123, 255, 1)",
                    tension: 0.3,
                    fill: true,
                    backgroundColor: "rgba(0, 123, 255, 0.1)",
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}

const overlay = document.getElementById("overlay");
if (document.getElementById("overlay")) {
    const campaignPanel = document.getElementById("campaignPanel");
    const invitePanel = document.getElementById("invitePanel");

    const startCampaignBtn = document.getElementById("startCampaignBtn");
    const inviteTeamBtn = document.getElementById("inviteTeamBtn");

    const closeCampaignBtn = document.getElementById("closeCampaignPanel");
    const cancelCampaignBtn = document.getElementById("cancelCampaign");
    const closeInviteBtn = document.getElementById("closeInvitePanel");

    function openPanel(panel) {
        panel.classList.add("active");
        overlay.classList.add("active");
        document.body.style.overflow = "hidden";
    }

    function closePanel(panel) {
        panel.classList.remove("active");
        overlay.classList.remove("active");
        document.body.style.overflow = "";
    }

    startCampaignBtn.addEventListener("click", () => openPanel(campaignPanel));
    inviteTeamBtn.addEventListener("click", () => openPanel(invitePanel));

    closeCampaignBtn.addEventListener("click", () => closePanel(campaignPanel));
    cancelCampaignBtn.addEventListener("click", () =>
        closePanel(campaignPanel)
    );
    closeInviteBtn.addEventListener("click", () => closePanel(invitePanel));

    overlay.addEventListener("click", () => {
        closePanel(campaignPanel);
        closePanel(invitePanel);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("submitCampaign")) {
        const form = document.getElementById("documentForm");

        form.addEventListener("submit", function (e) {
            document.getElementById("validFieldsresponse").value = 1;

            validateField(
                "full-name",
                "fullNameError",
                "Please enter a Full Name."
            );
            validateField(
                "dob",
                "dobError",
                "Please enter a valid Date of Birth."
            );
            validateField("gender", "genderError", "Please select a Gender.");
            validateField(
                "location",
                "locationError",
                "Please enter the location of the item."
            );

            if (documentType.value === "3") {
                validateField(
                    "aadhar_card",
                    "aadharCardError",
                    "Please enter your Aadhaar Number."
                );
                validateField(
                    "mobile",
                    "mobileError",
                    "Please enter Mobile Number linked with Aadhaar."
                );
                // Aadhaar email validation (empty and format)
                const aadharEmail = document.getElementById("email");
                const aadharEmailError = document.getElementById("emailError");
                const emailValue = aadharEmail ? aadharEmail.value.trim() : "";
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailValue) {
                    aadharEmailError.innerText =
                        "Please enter Email Address linked with Aadhaar.";
                    document.getElementById("validFieldsresponse").value = 0;
                } else if (!emailPattern.test(emailValue)) {
                    aadharEmailError.innerText = "Email format is incorrect.";
                    document.getElementById("validFieldsresponse").value = 0;
                } else {
                    aadharEmailError.innerText = "";
                }
            }

            if (documentType.value === "4") {
                validateField(
                    "license-num",
                    "documentNumberError",
                    "Please enter your PAN Number."
                );
                validateField(
                    "relative_name",
                    "relativeNameError",
                    "Please enter Father/Husband Name with Aadhaar."
                );
                validateField(
                    "location",
                    "locationError",
                    "Please enter the location of the item."
                );
            }

            if (documentType.value === "2") {
                validateField(
                    "nationality",
                    "nationalityError",
                    "Please select your Nationality."
                );
                validateField(
                    "passport_number",
                    "passportNumberError",
                    "Please enter your Passport Number."
                );
                validateField(
                    "issue_date",
                    "issueDateError",
                    "Please enter the Date of Issue."
                );
                validateField(
                    "expire-date",
                    "expireDateError",
                    "Please enter the Expiry Date."
                );
            }

            if (documentType.value === "1") {
                validateField(
                    "driving-license",
                    "driving-licenseError",
                    "Please enter your Driving Licence Number."
                );
                validateField(
                    "expire-date",
                    "expireDateError",
                    "Please enter the Expiry Date."
                );
            }
            if (document.getElementById("validFieldsresponse").value == 0) {
                // in case of false
                e.preventDefault(); // Prevent API request
            }
        });

        function validateField(fieldId, errorId, errorMessage) {
            const field = document.getElementById(fieldId);
            const errorField = document.getElementById(errorId);

            if (field && field.value.trim() === "") {
                errorField.innerText = errorMessage;
                document.getElementById("validFieldsresponse").value = 0;
            } else if (
                fieldId == "dob" ||
                fieldId == "issue_date" ||
                fieldId == "expire-date"
            ) {
                if (!isValidDate(field.value)) {
                    errorField.innerText = "Invalid date format or value.";
                } else {
                    errorField.innerText = "";
                }
            } else if (fieldId == "full-name" || fieldId == "relative_name") {
                if (!isValidName(field.value)) {
                    errorField.innerText = "Please enter valid name.";
                } else {
                    errorField.innerText = "";
                }
            } else {
                errorField.innerText = "";
            }
        }
    }
});
