

import './bootstrap';

!function(t){"use strict";var a="other";t("body").on("change",'input[name="gateway"]',function(e){e.preventDefault();var r=t("button#paymentSubmit");r.removeAttr("disabled"),t("html, body").animate({scrollTop:r.offset().top-250},600),a=t(this).attr("data-class")}),t("body").on("click","#paymentSubmit",function(e){e.preventDefault(),t(this).addClass("loadingbar primary").prop("disabled",!0),"Razorpay"===a?t(".razorpay-payment-button").trigger("click"):t(this).closest("form").trigger("submit")})}(jQuery);
