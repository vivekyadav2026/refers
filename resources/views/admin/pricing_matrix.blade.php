<div x-data="servicePricingManager()" @load-service-pricing.window="loadData($event.detail)" class="mb-8">
    
    {{-- PLANS SECTION --}}
    <div class="mb-5 border border-indigo-100 rounded-2xl overflow-hidden bg-white">
        <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                <i data-lucide="layout-grid" class="w-4 h-4 text-indigo-500"></i> Service Plans
            </h4>
            <button type="button" @click="addPlan()" class="px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-xs font-bold rounded-lg transition-colors flex items-center gap-1.5">
                <i data-lucide="plus" class="w-3 h-3"></i> Add Plan
            </button>
        </div>
        
        <div class="p-5 space-y-6">
            <template x-for="(plan, pIndex) in plans" :key="'plan_'+pIndex">
                <div class="p-4 border border-slate-200 rounded-xl bg-slate-50/50 relative">
                    <button type="button" @click="removePlan(pIndex)" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Plan Name</label>
                            <input type="text" :name="`plans[${pIndex}][name]`" x-model="plan.name" @input="updateMatrix()"
                                class="w-full border border-slate-200 bg-white text-slate-900 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Delivery Time</label>
                            <input type="text" :name="`plans[${pIndex}][delivery]`" x-model="plan.delivery"
                                class="w-full border border-slate-200 bg-white text-slate-900 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Description</label>
                        <input type="text" :name="`plans[${pIndex}][description]`" x-model="plan.description"
                            class="w-full border border-slate-200 bg-white text-slate-900 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Features (One per line)</label>
                        <textarea :name="`plans[${pIndex}][features]`" x-model="plan.features" rows="3"
                            class="w-full border border-slate-200 bg-white text-slate-900 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 outline-none resize-y"></textarea>
                    </div>
                </div>
            </template>
            <div x-show="plans.length === 0" class="text-center py-4 text-slate-500 text-sm">
                No plans added. Add at least one plan.
            </div>
        </div>
    </div>

    {{-- PLATFORMS SECTION --}}
    <div class="mb-5 border border-indigo-100 rounded-2xl overflow-hidden bg-white">
        <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                <i data-lucide="layers" class="w-4 h-4 text-indigo-500"></i> Platforms (Optional)
            </h4>
            <button type="button" @click="addPlatform()" class="px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-xs font-bold rounded-lg transition-colors flex items-center gap-1.5">
                <i data-lucide="plus" class="w-3 h-3"></i> Add Platform
            </button>
        </div>
        
        <div class="p-5 space-y-3">
            <template x-for="(plat, platIndex) in platforms" :key="'plat_'+platIndex">
                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <input type="text" :name="`platforms[${platIndex}][name]`" x-model="plat.name" @input="updateMatrix()"
                            placeholder="Platform Name (e.g. WordPress)" 
                            class="w-full border border-slate-200 bg-slate-50 text-slate-900 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <button type="button" @click="removePlatform(platIndex)" class="p-2 text-slate-400 hover:text-red-500 bg-slate-100 hover:bg-red-50 rounded-lg transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </template>
            <div x-show="platforms.length === 0" class="text-center py-4 text-slate-500 text-sm">
                No platforms added.
            </div>
        </div>
    </div>

    {{-- PRICING MATRIX SECTION --}}
    <div class="border border-indigo-100 rounded-2xl overflow-hidden bg-white" x-show="plans.length > 0 && platforms.length > 0">
        <div class="p-4 bg-indigo-50/50 border-b border-indigo-100">
            <h4 class="text-xs font-black text-indigo-800 uppercase tracking-widest flex items-center gap-2">
                <i data-lucide="calculator" class="w-4 h-4 text-indigo-500"></i> Pricing Matrix (₹)
            </h4>
        </div>
        
        <div class="p-5 overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr>
                        <th class="p-3 bg-slate-50 border border-slate-200 font-bold text-slate-700 w-1/4">Platform \\ Plan</th>
                        <template x-for="(plan, pIndex) in plans" :key="'th_'+pIndex">
                            <th class="p-3 bg-slate-50 border border-slate-200 font-bold text-slate-700 text-center" x-text="plan.name || 'Unnamed Plan'"></th>
                        </template>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(plat, platIndex) in platforms" :key="'tr_'+platIndex">
                        <tr>
                            <td class="p-3 border border-slate-200 font-semibold text-slate-800 bg-slate-50/30" x-text="plat.name || 'Unnamed Platform'"></td>
                            <template x-for="(plan, pIndex) in plans" :key="'td_'+platIndex+'_'+pIndex">
                                <td class="p-2 border border-slate-200">
                                    <input type="number" step="0.01" min="0"
                                        :name="`pricing_matrix[${platIndex}][${pIndex}]`" 
                                        x-model="matrixValues[`${platIndex}_${pIndex}`]"
                                        class="w-full text-center border-0 bg-transparent focus:ring-2 focus:ring-indigo-500 rounded py-2 outline-none"
                                        placeholder="0.00">
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('servicePricingManager', () => ({
        plans: [],
        platforms: [],
        matrixValues: {}, // Keyed by `${platIndex}_${pIndex}`

        loadData(service) {
            this.matrixValues = {};
            if (service) {
                // Load Plans
                if (service.plans) {
                    // Check if it's new dynamic array format or old assoc array
                    let loadedPlans = Array.isArray(service.plans) ? service.plans : Object.values(service.plans);
                    this.plans = loadedPlans.map(p => ({
                        name: p.name || '',
                        description: p.description || '',
                        delivery: p.delivery || '',
                        features: Array.isArray(p.features) ? p.features.join('\n') : (p.features || '')
                    }));
                } else {
                    this.plans = [];
                }

                // Load Platforms
                if (service.platforms) {
                    this.platforms = (Array.isArray(service.platforms) ? service.platforms : Object.values(service.platforms)).map(p => ({
                        name: p.name || ''
                    }));
                } else {
                    this.platforms = [];
                }

                // Load Pricing Matrix
                if (service.pricing_matrix) {
                    this.platforms.forEach((plat, platIndex) => {
                        this.plans.forEach((plan, pIndex) => {
                            let price = 0;
                            if (service.pricing_matrix[plat.name] && service.pricing_matrix[plat.name][plan.name] !== undefined) {
                                price = service.pricing_matrix[plat.name][plan.name];
                            }
                            this.matrixValues[`${platIndex}_${pIndex}`] = price;
                        });
                    });
                } else if (service.platforms && service.plans) {
                    // Fallback to legacy pricing where platforms had an additional flat price and plans had a base price
                    let legacyPlans = service.plans;
                    this.platforms.forEach((plat, platIndex) => {
                        this.plans.forEach((plan, pIndex) => {
                            let planKey = Object.keys(legacyPlans).find(k => legacyPlans[k].name === plan.name);
                            let basePrice = planKey && legacyPlans[planKey].price ? parseFloat(legacyPlans[planKey].price) : 0;
                            let platPrice = plat.price !== undefined ? parseFloat(plat.price) : 0;
                            this.matrixValues[`${platIndex}_${pIndex}`] = basePrice + platPrice;
                        });
                    });
                }
            } else {
                // Defaults for new service
                this.plans = [
                    { name: 'Standard', description: '', delivery: '', features: '' }
                ];
                this.platforms = [];
            }
            this.updateMatrix();
        },
        
        addPlan() {
            this.plans.push({ name: 'New Plan', description: '', delivery: '', features: '' });
            this.updateMatrix();
            this.$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); });
        },
        
        removePlan(index) {
            this.plans.splice(index, 1);
            this.rebuildMatrixKeys();
        },
        
        addPlatform() {
            this.platforms.push({ name: 'New Platform' });
            this.updateMatrix();
            this.$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); });
        },
        
        removePlatform(index) {
            this.platforms.splice(index, 1);
            this.rebuildMatrixKeys();
        },
        
        updateMatrix() {
            // Just ensure keys exist
            this.platforms.forEach((plat, platIndex) => {
                this.plans.forEach((plan, pIndex) => {
                    let key = `${platIndex}_${pIndex}`;
                    if (this.matrixValues[key] === undefined) {
                        this.matrixValues[key] = '';
                    }
                });
            });
        },
        
        rebuildMatrixKeys() {
            // If rows/cols are removed, we might lose track of which index is which. 
            // In a real app we'd use unique IDs, but array indexes are what we submit.
            // For simplicity, we just clean up old keys that are out of bounds.
            let newMatrix = {};
            this.platforms.forEach((plat, platIndex) => {
                this.plans.forEach((plan, pIndex) => {
                    let key = `${platIndex}_${pIndex}`;
                    newMatrix[key] = this.matrixValues[key] || '';
                });
            });
            this.matrixValues = newMatrix;
        }
    }));
});
</script>
