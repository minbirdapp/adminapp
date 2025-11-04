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
    // cancelCampaignBtn.addEventListener("click", () => closePanel(campaignPanel));
    closeInviteBtn.addEventListener("click", () => closePanel(invitePanel));

    overlay.addEventListener("click", () => {
        closePanel(campaignPanel);
        closePanel(invitePanel);
    });
}
jQuery(document).on("click", ".openConnectModal", function () {
    jQuery("#data_brand_id").val(jQuery(this).attr("data-attr-id"));
    jQuery("#connectModal").modal("show");
});
jQuery(document).on("click", ".openSocialMedia", function () {
    jQuery("#data_account_type").val(jQuery(this).attr("data-account-type"));
    jQuery("#instagramModal").modal("show");
});
jQuery(document).on("click", ".connectPersonalAccount", function () {
    var accountType = jQuery("#data_account_type").val();
    var brandId = jQuery("#data_brand_id").val();
    $.ajax({
        url: addSocialMediaAccount,
        type: "POST",
        dataType: "json",
        data: {
            account_type: accountType,
            brand_id: brandId,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            window.location.reload();
        },
        error: function (xhr) {
            alert("Error: " + xhr.status);
        },
    });
    jQuery("#instagramModal").modal("hide");
});

jQuery(document).on("keyup", ".searchBrandData", function () {
    var search = jQuery(this).val();
    $.ajax({
        url: searchBrandUrl,
        type: "get",
        data: {
            search: search
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            jQuery('#searchBrandData').html(response);
        },
        error: function (xhr) {
            alert("Error: " + xhr.status);
        },
    });
    jQuery("#instagramModal").modal("hide");
});

jQuery(document).on("click", "#addUrl", function () {
    var trackerName = jQuery(this).parent().parent().find(".trackerName").val();
    var trackerUrl = jQuery(this).parent().parent().find(".trackerUrl").val();
    if (!isValidURL(trackerUrl)) {
        jQuery(this).parent().parent().find(".trackerUrl").css("border", "red");
    }
    jQuery(".trackingUrls").append(
        '<div class="input-group mb-3">          <input type="hidden" name="tracker[name][]" value="' +
            trackerName +
            '">              <span class="input-group-text">' +
            trackerName +
            '</span>                        <input type="text" name="tracker[url][]" class="form-control trackerUrl" value="' +
            trackerUrl +
            '">                                        <button class="delete-btn deleteTrackingUrl"><i class="fa-solid fa-trash"></i></button>                    </div>'
    );
});
jQuery(document).on("click", "#submitCampaign", function () {
    jQuery("#submitCamp").click();
});
jQuery(document).on("click", ".deleteTrackingUrl", function () {
    jQuery(this).parent().remove();
});
function isValidURL(str) {
    try {
        new URL(str);
        return true;
    } catch (_) {
        return false;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("submitCampaign")) {
        const form = document.getElementById("documentForm");

        form.addEventListener("submit", function (e) {
            document.getElementById("validFieldsresponse").value = 1;
            validateField("name", "nameError", "Please enter a Campaign Name.");
            validateField(
                "brand_id",
                "brand_idError",
                "Please Select a brand."
            );
            validateField(
                "status",
                "statusError",
                "Please select Campaign Status."
            );
            validateField(
                "objective",
                "objectiveError",
                "Please enter a objective for Campaign."
            );
            validateField(
                "notes",
                "notesError",
                "Please enter a Campaign notes."
            );
            validateField(
                "start_date",
                "start_dateError",
                "Please select start date."
            );
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
            } else if (fieldId == "start_date" || fieldId == "end_date") {
                if (!isValidDate(field.value)) {
                    errorField.innerText = "Invalid date format or value.";
                } else {
                    errorField.innerText = "";
                }
            } else {
                errorField.innerText = "";
            }
        }
    }
});
