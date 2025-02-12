<x-app-layout>
   <div class="container-fluid py-4">
       <div class="card">
           <div class="card-header pb-0">
               <h6>Google Ads Performance</h6>
               <small>Monitor key metrics and optimize your Google Ads campaigns.</small>
           </div>
           <div class="card-body">
               <canvas id="googleAdsChart"></canvas>
           </div>
       </div>

       <div class="card mt-4">
           <div class="card-header pb-0">
               <h6>Budget Summary</h6>
           </div>
           <div class="card-body">
               <ul class="list-group">
                   <li class="list-group-item">Total Budget: ${{ $budgetSummary['total_budget'] ?? 'N/A' }}</li>
                   <li class="list-group-item">Spent: ${{ $budgetSummary['spent'] ?? 'N/A' }}</li>
                   <li class="list-group-item">Remaining: ${{ $budgetSummary['remaining'] ?? 'N/A' }}</li>
                   <li class="list-group-item">Percentage Spent: {{ $budgetSummary['percentage_spent'] ?? '0' }}%</li>
               </ul>
           </div>
       </div>
   </div>

   <script>
   document.addEventListener("DOMContentLoaded", function() {
       var ctx = document.getElementById("googleAdsChart").getContext("2d");
       new Chart(ctx, {
           type: "line",
           data: {
               labels: @json($budgetSummary['dates'] ?? []),
               datasets: [{
                   label: "Clicks",
                   data: @json($budgetSummary['clicks'] ?? []),
                   borderColor: "#4285F4",
                   fill: false
               }]
           }
       });
   });
   </script>
</x-app-layout>
