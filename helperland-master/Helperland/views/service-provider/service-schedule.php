<div id="calendar">
    <!-- CALENDAR WILL DYNAMIC GENERATE BY JS -->
</div>    

<script>
    async function fetchSchedules(){
        const response = await fetch(`${BASE_URL}/service-provider/service/schedule/`);
        const data = await response.json();
        let spScheduleDates = [];
        for(let i=0; i<data.length; i++){
            spScheduleDates.push({
                title : data[i].CustomerName,
                start : `${data[i].ServiceDate} ${data[i].StartTime}`,
                end : `${data[i].ServiceDate} ${data[i].EndTime}`,
            })
        }
        return spScheduleDates;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events : async function(){
                return await fetchSchedules();
            }            
        });
        calendar.render();
    });
</script>
