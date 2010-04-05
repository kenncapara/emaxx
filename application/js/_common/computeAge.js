App.computeAge = function (birth) {
    
    // Who knew it was this hard to compute age?
    
    function getMonthLength(month,year,julianFlag) {
        var ml;
        if (month==1 || month==3 || month==5 || month==7 || month==8 || month==10||month==12) {
            ml = 31;
        } else {
            if (month==2) {
                ml = 28;
                if (!(year%4) && (julianFlag==1 || year%100 || !(year%400))) {
                    ml++;
                }
            } else {
                ml = 30;
            }
        }
        return ml;    
    }

    // ZOMG whoever wrote this age calc code doesn't like long variables.
    var now = new Date();
    var yd = now.format('Y');
    var md = now.format('m');
    var dd = now.format('d');

    var yb = birth.format('Y');
    var mb = birth.format('m');
    var db = birth.format('d');

    var mLength = 0;
    var isJulian = 0;

    var ma = 0;
    var ya = 0;

    var da = dd-db;
    // This is the all-important day borrowing code.
    if (da < 0) {
        md--;
        // Borrow months from the year if necesssary.
        if (md < 1) {
            yd--;
    	    md = md + 12;
        }
    
        ml = getMonthLength(md,yd,isJulian);
    	da = da + ml;
    }

    ma = md - mb;
    // Month borrowing code - borrows months from years.
    if (ma < 0) {
        yd--;
        ma=ma+12;
    }

    ya = yd - yb;
    return ya;
};