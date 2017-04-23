function CronType(val){
        this.strVal=val
}

var NONE = new CronType('none')
function noneStr(values,aux){
    return ''
}
NONE.toStr=noneStr

var EVERY = new CronType('every')
function everyStr(values,aux){
    return 'every'+aux
}
EVERY.toStr=everyStr

var FROMTO = new CronType('fromto')
function fromtoStr(values,aux){
    return 'from '+values[0]+' to '+values[1]+aux
}
FROMTO.toStr =fromtoStr
var EACH = new CronType('each')
function eachStr(values,aux){
    end=' '
    if(parseInt(values[0])>1){
        end='s '
    }
    return 'each '+values[0]+aux+end
}
EACH.toStr = eachStr

var AT = new CronType('at')
function atStr(values,aux){
    return 'at '+values.join(',')+aux+' '
} 
AT.toStr =atStr

var ATEACH = new CronType('ateach')
function ateachStr(values,aux){
    end=' '
    if(parseInt(values[0])>1){
        end='s '
    }
    return 'at '+values[0]+ ' each '+values[1]+aux+end
}
ATEACH.toStr =ateachStr
 
var FROMTOEACH = new CronType('fromtoeach')
function fromtoeachStr(values,aux){
    return 'from  '+values[0]+ ' to '+values[1]+' each '+values[2]+aux
}
FROMTOEACH.toStr =fromtoeachStr

var LAST = new CronType('last')
function lastStr(values,aux){
    return 'last '+aux
}
LAST.toStr = lastStr

var WEEK = new CronType('week')
function weekStr(values,aux){
    return 'weekdays'
}
WEEK.toStr = weekStr

/*Codigo de parsing do cron
 * 
 */ 


function CronPart(crontype,values){
    
    this.crontype=crontype
    this.values=values
    this.toString = function __str__(){
        return this.crontype.toStr(this.values,' minutes')
    }
}
        

function parseMinute(str,strType){
	if(strType==='general'){
		if(!generalValidation(str)){
			throw 'could not parse '+str;
		}
	}else if(strType==='dayOfMonth'){
		if(!dayOfMonthValidation(str)){
			throw 'could not parse '+str;
			
		}
		
	}
	
    if (str=='?'){
        return new CronPart(NONE)
    }
    else if (str=='*'){
        return new CronPart(EVERY)
    }
    else if (/^\d+(,\d+)*$/.test(str)){
        nums = str.split(',')
        return new CronPart(AT,nums)
    }
    else if (/^\d+\/\d+$/.test(str)){
        nums = str.split('/')
        return new CronPart(ATEACH,nums)
    }
    else if( /^\d+\-\d+$/.test(str)){
        nums = str.split('-')
        return new CronPart(FROMTO,nums)
    }
    else if ( /^\d+\-\d+\/\d+$/.test(str)){
        nums = str.split('-')
        nums2 =nums[1].split('/')
        return new CronPart(FROMTOEACH,[nums[0],nums2[0]],nums2[1]);
    }else if('L'==str){
    	return new CronPart(LAST)
    }else if('W'==str){
    	return new CronPart(WEEK)
    }
    else{
        throw 'could not parse expression:'+str;
    }
}


function _transformDayMonth(dayPart,monthPart){
	
    res=''
    if (monthPart.crontype==EVERY && dayPart.crontype==EVERY){
            res+='every day '
    }
    else{
    	
        if (dayPart.crontype==AT){
			res+='on '+dayPart.values.map(function(obj){
				return obj+'th'
			}).join(',')+' '
        }
        else if (FROMTO==dayPart.crontype){
            res+='from the '+dayPart.values[0]+'th to '+dayPart.values[1]+'th '
        }
    }
    res = res.replace(' 1th', ' 1st').replace(' 2th',' 2nd').replace(' 3th',' 3rd')
    res = res.replace(',1th', ',1st').replace(',2th',',2nd').replace(',3th',',3rd')
    return res
}

function _transformMinute(minutePart){
    return minutePart.crontype.toStr(minutePart.values,' minutes')
}

var months=['January','February','March','April','May','June','July','August','September','October','Novembe','December']
function _transformMonth(monthPart){
    res=''
    if (monthPart.crontype==EVERY){
        res+='of every month '
    }
    else if (monthPart.crontype==AT){
    	arr = monthPart.values.map(function(x){return months[parseInt(x)-1]})
        res+='of '+arr.join(',')+' '
    }
    else if (monthPart.crontype==FROMTO){
    	
         res+='from '+months[parseInt(monthPart.values[0])-1]+' to '+months[parseInt(monthPart.values[1])-1]+' '
    }
    return res
}

    /*Function wich take all the CronPart's extracted from a expression, 
    && translate it to English.
    */
function _transform(secondPart,minutePart,hourPart,dayPart,monthPart,weekPart){
    res = ''
    if (hourPart.crontype==EVERY){
        if (minutePart.crontype==EVERY){
            res+='every minute '
        }
        else
            res+=_transformMinute(minutePart)+' every hour '
    }
    else if (hourPart.crontype==AT && hourPart.values.length==1){
        if (minutePart.crontype==AT && minutePart.values.length==1){
           res+=" at "+("00"+hourPart.values[0]).substr(-2)+":"+("00"+minutePart.values[0]).substr(-2)+" "
        }
    }
    else{
        res+=hourPart.crontype.toStr(hourPart.values,' hour')
        res+=minutePart.crontype.toStr(minutePart.values,' minutes')
    }
    res+=_transformDayMonth(dayPart, monthPart)
    if (dayPart.crontype!=EVERY || weekPart.crontype==NONE){
        res+=_transformMonth(monthPart)
    }
    res=res.replace(/\s+/g,' ')
    return res.trim()
}

function _rec_transform(part,unit,afterpart){
	if(part.crontype==AT){
		return 'at '+part.values[0]
	}else if(part.crontype==ATEACH){
		return 'starting at '+part.values[0]+' and each '+part.values[1]+' '+unit
	}else if(part.crontype == EVERY){
		if(afterpart.crontype != EVERY && afterpart.crontype !=NONE){
			return 'every '+unit
		}
	}else if(part.crontype == FROMTO){
		return 'from '+part.values[0]+' to '+part.values[1]
	}
	
	
}


function generalValidation(exp){
	return /^[\d,\-\*\/]+$/.test(exp)

}
function dayOfMonthValidation(exp){
	return /^[\d,\-\*\/LW\?]+$/.test(exp)
}


GENERAL = 'general'
D_MONTH = 'dayOfMonth'


function cronParse(str,quartz){
	
    /*Translates from cron expression to english.
    */
   
    divs = str.split(' ')
    secondPart=null
    if(quartz){
    	secondPart = parseMinute(divs[0],GENERAL)
    }
    
    minutePart = parseMinute(divs[0],GENERAL)
    hourPart = parseMinute(divs[1],GENERAL)
    dayPart = parseMinute(divs[2],'dayOfMonth')
    monthPart = parseMinute(divs[3],GENERAL)
    weekPart = parseMinute(divs[4],'dayOfMonth')
    
    return _transform(secondPart,minutePart,hourPart,dayPart,monthPart,weekPart)
}
    
    
    
    