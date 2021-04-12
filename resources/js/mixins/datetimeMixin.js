import moment from "moment";
import "moment-timezone"

export const datetimeMixin = {
  computed: {
    /**
     * Get now date-time
     * only two arguments: ["format", "toISOString"]
     * 
     * @type {String}
     */
    today() {
      return (format) => moment()[format]()
    },

    cityTimezone() {
      let userTimezone = moment.tz.guess();
      return userTimezone.substr(userTimezone.indexOf("/") + 1);
    },

    formatingDatetime: () => {
      return (datetime, format) => {
        moment.locale('th')
        // if (moment(datetime).format('hh') === '12') {
        //   let date = moment(datetime).format("DD MMM YYYY")
        //   let minute = moment(datetime).format("hh:mma").substr(2)
        //   return `${date} 00${minute}`
        // }
        let formattedDatetime = datetime
          ? moment(datetime).add(543, 'year').format(format)
          : 'ไม่ระบุ';
        
        return formattedDatetime;
      }
    },
  },

  methods: {
    diffMonth(monthStart, monthEnd) {
      return Math.ceil(moment(monthEnd).diff(moment(monthStart), 'months', true)) + 1;
    }
  }
}