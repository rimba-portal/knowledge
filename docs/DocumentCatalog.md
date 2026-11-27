# RIMBA Governed Knowledge Template Catalogue

> **Status:** Revised candidate catalogue  
> **Scope:** Enterprise governance, site governance, corporate and engineering support, MESA/MOM operations, logistics and competence knowledge  
> **Catalogue size:** 74 candidates: 40 existing MESA operational templates and 34 governance/corporate/engineering additions

## Purpose

This catalogue defines candidate controlled-document templates that may satisfy governed knowledge requirements raised from the RIMBA operational hierarchy and MESA domain models. It is a catalogue of candidates—not an instruction to create every document for every entity. Domain owners must approve the applicable requirement rules and watched attributes before automatic provisioning is enabled.

The authoritative operational hierarchy remains:

```text
Enterprise → Site → Area → Work Center → Work Unit
```

Equipment/Assets, Processes and Personnel are associated with hierarchy entities; they are not additional hierarchy levels. A requirement may exist before the corresponding controlled document has been authored.

## Canonical document naming

All patterns in this revision are classification-first:

```text
Entity-specific: [DocType]-[Operation]-[Pillar]-[Model]-[short_code](-[Sequence])
Business:        [DocType]-[Operation]-[Pillar](-[Sequence])
Revision file:   [DocumentCode]_[Revision](_[Locale]).[ext]
```

- `short_code` is the immutable identifier of the source record; MaterialLot and MaterialSublot use ten characters, while other registered source models use eight by default.
- `Sequence` is an optional stable numeric suffix of at least three digits when more than one controlled document would otherwise receive the same code.
- Company-wide business documents omit the model and entity segment.
- Entity-specific documents include one registered model code and one source identifier.
- A document code remains stable across revisions.

### Code reference

| Category | Codes |
|---|---|
| Document type | `PY` Policy; `PE` Procedure; `PN` Plan; `CP` Control Plan; `WI` Work Instruction; `SN` Specification; `SD` Standard; `TM` Training Material; `FM` Form; `CT` Checklist; `RD` Record; `RT` Report |
| Operation | `P` Production; `I` Inventory; `M` Maintenance; `Q` Quality; `E` Enterprise; `C` CyberSecurity/DataSecurity/Information; `S` Physical Security & Safety |
| ISA-95 pillar | `RD` Resource Definitions; `PC` Production Capability; `PD` Product Definition; `PS` Production Schedule; `PP` Production Performance |
| Existing model | `AT` Asset; `ET` Equipment; `WC` WorkCenter; `WU` WorkUnit; `OL` OperationalLocation; `ML` MaterialLot; `MS` MaterialSublot; `MD` MaterialDefinition; `SF` Staff; `JO` JobOrder; `NR` NonconformanceRecord |
| Proposed hierarchy-model additions | `EN` Enterprise; `SI` Site; `AR` Area |

> **Registration prerequisite:** `EN`, `SI` and `AR` are proposed additions and must be registered as unique model-code segments before any entity-scoped patterns using them are enabled. `WC` and `WU` remain distinct; there is no separate WorkStation table.

## Catalogue summary

| Family | Count | Scope |
|---|---:|---|
| MESA operational | 40 | Factory, warehouse, equipment, materials, execution, quality and role training |
| Enterprise governance | 7 | Enterprise-wide policies, procedures and objectives |
| Site governance | 4 | Local management, emergency, continuity and access controls |
| Engineering / NPI | 5 | NPI, design control, failure analysis and reliability |
| Corporate quality | 4 | QMS, audit, customer quality and metrology |
| Supply chain / planning | 3 | Planning, scheduling, consignment and accountability |
| IT / factory automation | 5 | IT/OT governance, MES integration and infrastructure |
| Finance / procurement | 2 | Manufacturing-relevant supplier, purchasing and cost controls |
| HR / EHS / facilities | 4 | Competence, safety, emergency and contractor/facilities control |
| **Total** | **74** | **Enterprise + corporate + factory + logistics** |

## 1. Existing MESA operational templates (revised naming)

The following 40 candidates retain their existing template-file references but use the canonical classification-first code patterns and the revised titles/types defined by the naming standard. Relative file names are not renamed by this catalogue revision.

| # | Trigger | Operation | Code pattern | Type | Template title | ISA-95 pillar | Template file |
|---:|---|---|---|---|---|---|---|
| 1 | Asset (`mom_assets`) | Production (P) | `WI-P-PD-AT-[short_code]` | Work Instruction | Machine Operating Limits & Setup Guide | Product Definition (PD) | [01_at_p_machine-operating-limits-setup-guide.md](templates/01_at_p_machine-operating-limits-setup-guide.md) |
| 2 | Asset (`mom_assets`) | Inventory (I) | `SN-I-RD-AT-[short_code]` | Specification | Spare Parts & Tooling Storage Specification | Resource Definitions (RD) | [02_at_i_spare-parts-tooling-storage-specification.md](templates/02_at_i_spare-parts-tooling-storage-specification.md) |
| 3 | Asset (`mom_assets`) | Maintenance (M) | `PE-M-RD-AT-[short_code]` | Procedure | OEM Service & Preventive Maintenance (PM) Procedure | Resource Definitions (RD) | [03_at_m_oem-service-preventive-maintenance-pm-procedure.md](templates/03_at_m_oem-service-preventive-maintenance-pm-procedure.md) |
| 4 | Asset (`mom_assets`) | Quality (Q) | `PE-Q-PC-AT-[short_code]` | Procedure | Asset Calibration & Measurement Uncertainty Procedure | Production Capability (PC) | [04_at_q_asset-calibration-measurement-uncertainty-procedure.md](templates/04_at_q_asset-calibration-measurement-uncertainty-procedure.md) |
| 5 | Equipment (`mom_equipment`) | Production (P) | `WI-P-PD-ET-[short_code]` | Work Instruction | Station Operating & HMI Cycle Start Work Instruction | Product Definition (PD) | [05_et_p_station-operating-hmi-cycle-start-work-instruction.md](templates/05_et_p_station-operating-hmi-cycle-start-work-instruction.md) |
| 6 | Equipment (`mom_equipment`) | Inventory (I) | `WI-I-PS-ET-[short_code]` | Work Instruction | Line-Side Point-of-Use Staging Work Instruction | Production Schedule (PS) | [06_et_i_line-side-point-of-use-staging-work-instruction.md](templates/06_et_i_line-side-point-of-use-staging-work-instruction.md) |
| 7 | Equipment (`mom_equipment`) | Maintenance (M) | `PE-M-RD-ET-[short_code]` | Procedure | Lockout/Tagout (LOTO) & Fault Recovery Procedure | Resource Definitions (RD) | [07_et_m_lockout-tagout-loto-fault-recovery-procedure.md](templates/07_et_m_lockout-tagout-loto-fault-recovery-procedure.md) |
| 8 | Equipment (`mom_equipment`) | Quality (Q) | `CT-Q-PC-ET-[short_code]` | Checklist | First-Piece Verification & Station Capability Checklist | Production Capability (PC) | [08_et_q_first-piece-verification-station-capability-procedure.md](templates/08_et_q_first-piece-verification-station-capability-procedure.md) |
| 9 | WorkCenter / WorkUnit (`mom_work_centers` / `mom_work_units`) | Production (P) | `SN-P-RD-WC-[short_code]`<br>`SN-P-RD-WU-[short_code]` | Specification | Line Balance, Cell Layout & Shift Handover Standard | Resource Definitions (RD) | [09_wc_p_line-balance-cell-layout-shift-handover-standard.md](templates/09_wc_p_line-balance-cell-layout-shift-handover-standard.md) |
| 10 | WorkCenter / WorkUnit (`mom_work_centers` / `mom_work_units`) | Inventory (I) | `SN-I-PS-WC-[short_code]`<br>`SN-I-PS-WU-[short_code]` | Specification | Line-Side Buffer & WIP Lane Specification | Production Schedule (PS) | [10_wc_i_line-side-buffer-wip-lane-specification.md](templates/10_wc_i_line-side-buffer-wip-lane-specification.md) |
| 11 | WorkCenter / WorkUnit (`mom_work_centers` / `mom_work_units`) | Maintenance (M) | `PE-M-RD-WC-[short_code]`<br>`PE-M-RD-WU-[short_code]` | Procedure | Area Utility Isolation Map & 5S Autonomous Maintenance | Resource Definitions (RD) | [11_wc_m_area-utility-isolation-map-5s-autonomous-maintenance.md](templates/11_wc_m_area-utility-isolation-map-5s-autonomous-maintenance.md) |
| 12 | WorkCenter / WorkUnit (`mom_work_centers` / `mom_work_units`) | Quality (Q) | `CT-Q-PS-WC-[short_code]`<br>`CT-Q-PS-WU-[short_code]` | Checklist | Line Clearance, Changeover & Area PPE Checklist | Production Schedule (PS) | [12_wc_q_line-clearance-changeover-area-ppe-checklist.md](templates/12_wc_q_line-clearance-changeover-area-ppe-checklist.md) |
| 13 | OperationalLocation (`mom_operational_locations`) | Production (P) | `WI-P-PS-OL-[short_code]` | Work Instruction | Point-of-Use Kitting & Feed Work Instruction | Production Schedule (PS) | [13_ol_p_point-of-use-kitting-feed-work-instruction.md](templates/13_ol_p_point-of-use-kitting-feed-work-instruction.md) |
| 14 | OperationalLocation (`mom_operational_locations`) | Inventory (I) | `PE-I-RD-OL-[short_code]` | Procedure | Putaway, Picking, FIFO/FEFO & Cycle Count Procedure | Resource Definitions (RD) | [14_ol_i_putaway-picking-fifo-fefo-cycle-count-procedure.md](templates/14_ol_i_putaway-picking-fifo-fefo-cycle-count-procedure.md) |
| 15 | OperationalLocation (`mom_operational_locations`) | Maintenance (M) | `SN-M-RD-OL-[short_code]` | Specification | Rack Load Limit & Warehouse Dock Safety Specification | Resource Definitions (RD) | [15_ol_m_rack-load-limit-warehouse-dock-safety-specification.md](templates/15_ol_m_rack-load-limit-warehouse-dock-safety-specification.md) |
| 16 | OperationalLocation (`mom_operational_locations`) | Quality (Q) | `PE-Q-RD-OL-[short_code]` | Procedure | Quarantine Zone & Environmental Control Procedure | Resource Definitions (RD) | [16_ol_q_quarantine-zone-environmental-control-procedure.md](templates/16_ol_q_quarantine-zone-environmental-control-procedure.md) |
| 17 | MaterialLot (`mom_material_lots`) | Production (P) | `WI-P-PP-ML-[short_code]` | Work Instruction | Lot Consumption & Genealogy Scan Work Instruction | Production Performance (PP) | [17_ml_p_lot-consumption-genealogy-scan-work-instruction.md](templates/17_ml_p_lot-consumption-genealogy-scan-work-instruction.md) |
| 18 | MaterialLot (`mom_material_lots`) | Inventory (I) | `WI-I-PS-ML-[short_code]` | Work Instruction | Goods Receiving, Putaway & Container Labeling WI | Production Schedule (PS) | [18_ml_i_goods-receiving-putaway-container-labeling-wi.md](templates/18_ml_i_goods-receiving-putaway-container-labeling-wi.md) |
| 19 | MaterialLot (`mom_material_lots`) | Maintenance (M) | `SN-M-RD-ML-[short_code]` | Specification | Consumable Lubricants & Chemicals Handling Specification | Resource Definitions (RD) | [19_ml_m_consumable-lubricants-chemicals-handling-wi.md](templates/19_ml_m_consumable-lubricants-chemicals-handling-wi.md) |
| 20 | MaterialLot (`mom_material_lots`) | Quality (Q) | `CP-Q-PP-ML-[short_code]` | Control Plan | Receiving Inspection Plan & CoA/CoC Verification | Production Performance (PP) | [20_ml_q_receiving-inspection-plan-coa-coc-verification.md](templates/20_ml_q_receiving-inspection-plan-coa-coc-verification.md) |
| 21 | MaterialSublot (`mom_material_sublots`) | Production (P) | `WI-P-PP-MS-[short_code]` | Work Instruction | Partial Reel/Bag Return & Splice Work Instruction | Production Performance (PP) | [21_ms_p_partial-reel-bag-return-splice-work-instruction.md](templates/21_ms_p_partial-reel-bag-return-splice-work-instruction.md) |
| 22 | MaterialSublot (`mom_material_sublots`) | Inventory (I) | `WI-I-PS-MS-[short_code]` | Work Instruction | Sublot Decanting, Splitting & Relabeling WI | Production Schedule (PS) | [22_ms_i_sublot-decanting-splitting-relabeling-wi.md](templates/22_ms_i_sublot-decanting-splitting-relabeling-wi.md) |
| 23 | MaterialSublot (`mom_material_sublots`) | Maintenance (M) | `WI-M-PS-MS-[short_code]` | Work Instruction | Spare Kit Sub-Assembly Packaging Work Instruction | Production Schedule (PS) | [23_ms_m_spare-kit-sub-assembly-packaging-work-instruction.md](templates/23_ms_m_spare-kit-sub-assembly-packaging-work-instruction.md) |
| 24 | MaterialSublot (`mom_material_sublots`) | Quality (Q) | `PE-Q-PP-MS-[short_code]` | Procedure | Sublot Traceability & Cross-Contamination Prevention Procedure | Production Performance (PP) | [24_ms_q_sublot-traceability-cross-contamination-prevention-wi.md](templates/24_ms_q_sublot-traceability-cross-contamination-prevention-wi.md) |
| 25 | MaterialDefinition (`mom_material_definitions`) | Production (P) | `SN-P-PD-MD-[short_code]` | Specification | Bill of Materials (BOM) & Substitution Specification | Product Definition (PD) | [25_md_p_bill-of-materials-bom-substitution-specification.md](templates/25_md_p_bill-of-materials-bom-substitution-specification.md) |
| 26 | MaterialDefinition (`mom_material_definitions`) | Inventory (I) | `SN-I-RD-MD-[short_code]` | Specification | Kanban Replenishment, Min/Max & Packaging Spec | Resource Definitions (RD) | [26_md_i_kanban-replenishment-min-max-packaging-spec.md](templates/26_md_i_kanban-replenishment-min-max-packaging-spec.md) |
| 27 | MaterialDefinition (`mom_material_definitions`) | Maintenance (M) | `SN-M-RD-MD-[short_code]` | Specification | Critical Spare Parts Technical Specification | Resource Definitions (RD) | [27_md_m_critical-spare-parts-technical-specification.md](templates/27_md_m_critical-spare-parts-technical-specification.md) |
| 28 | MaterialDefinition (`mom_material_definitions`) | Quality (Q) | `SN-Q-RD-MD-[short_code]` | Specification | Safety Data Sheet (SDS) & Incoming Material Test Spec | Resource Definitions (RD) | [28_md_q_safety-data-sheet-sds-incoming-material-test-spec.md](templates/28_md_q_safety-data-sheet-sds-incoming-material-test-spec.md) |
| 29 | Staff (`mom_staff`) | Production (P) | `TM-P-PC-SF-[short_code]` | Training Material | Certified Production Operator Training Curriculum | Production Capability (PC) | [29_sf_p_certified-production-operator-training-curriculum.md](templates/29_sf_p_certified-production-operator-training-curriculum.md) |
| 30 | Staff (`mom_staff`) | Inventory (I) | `TM-I-PC-SF-[short_code]` | Training Material | Forklift & Hazmat Material Handling Training | Production Capability (PC) | [30_sf_i_forklift-hazmat-material-handling-training.md](templates/30_sf_i_forklift-hazmat-material-handling-training.md) |
| 31 | Staff (`mom_staff`) | Maintenance (M) | `TM-M-PC-SF-[short_code]` | Training Material | LOTO & High-Voltage Maintenance Training | Production Capability (PC) | [31_sf_m_loto-high-voltage-maintenance-training.md](templates/31_sf_m_loto-high-voltage-maintenance-training.md) |
| 32 | Staff (`mom_staff`) | Quality (Q) | `TM-Q-PC-SF-[short_code]` | Training Material | Quality Inspector & Lab Calibration Training | Production Capability (PC) | [32_sf_q_quality-inspector-lab-calibration-training.md](templates/32_sf_q_quality-inspector-lab-calibration-training.md) |
| 33 | JobOrder (`mom_job_orders`) | Production (P) | `WI-P-PD-JO-[short_code]` | Work Instruction | Pinned Production Work Instruction & Routing | Product Definition (PD) | [33_jo_p_pinned-production-work-instruction-routing.md](templates/33_jo_p_pinned-production-work-instruction-routing.md) |
| 34 | JobOrder (`mom_job_orders`) | Inventory (I) | `CT-I-PS-JO-[short_code]` | Checklist | Job Kitting & Material Issue Checklist | Production Schedule (PS) | [34_jo_i_job-kitting-material-issue-checklist.md](templates/34_jo_i_job-kitting-material-issue-checklist.md) |
| 35 | JobOrder (`mom_job_orders`) | Maintenance (M) | `WI-M-PS-JO-[short_code]` | Work Instruction | Maintenance & Repair Work Order Instruction | Production Schedule (PS) | [35_jo_m_maintenance-repair-work-order-procedure.md](templates/35_jo_m_maintenance-repair-work-order-procedure.md) |
| 36 | JobOrder (`mom_job_orders`) | Quality (Q) | `CP-Q-PD-JO-[short_code]` | Control Plan | In-Process Quality Control Plan (QCP) | Product Definition (PD) | [36_jo_q_in-process-quality-control-plan-qcp.md](templates/36_jo_q_in-process-quality-control-plan-qcp.md) |
| 37 | NonconformanceRecord (`mom_nonconformance_records`) | Production (P) | `WI-P-PP-NR-[short_code]` | Work Instruction | Stop-Work Escalation & Approved Rework Instruction | Production Performance (PP) | [37_nr_p_stop-work-escalation-approved-rework-instruction.md](templates/37_nr_p_stop-work-escalation-approved-rework-instruction.md) |
| 38 | NonconformanceRecord (`mom_nonconformance_records`) | Inventory (I) | `PE-I-PP-NR-[short_code]` | Procedure | Quarantine Transfer & Blocked-Stock Procedure | Production Performance (PP) | [38_nr_i_quarantine-transfer-blocked-stock-procedure.md](templates/38_nr_i_quarantine-transfer-blocked-stock-procedure.md) |
| 39 | NonconformanceRecord (`mom_nonconformance_records`) | Maintenance (M) | `PE-M-PP-NR-[short_code]` | Procedure | Equipment Breakdown & Fault Tagging Procedure | Production Performance (PP) | [39_nr_m_equipment-breakdown-fault-tagging-procedure.md](templates/39_nr_m_equipment-breakdown-fault-tagging-procedure.md) |
| 40 | NonconformanceRecord (`mom_nonconformance_records`) | Quality (Q) | `PE-Q-PP-NR-[short_code]` | Procedure | Containment, Quarantine & MRB Disposition Procedure | Production Performance (PP) | [40_nr_q_containment-quarantine-mrb-disposition-procedure.md](templates/40_nr_q_containment-quarantine-mrb-disposition-procedure.md) |

## 2. Enterprise governance additions

Enterprise existence may establish requirements for business-level documents. Six rows below are deliberately business-scoped and therefore omit an entity segment; the quality-objectives plan remains Enterprise-entity-scoped.

| # | Trigger | Operation | Code pattern | Type | Template title | ISA-95 pillar | Scope/status |
|---:|---|---|---|---|---|---|---|
| 41 | Enterprise | Enterprise (E) | `PY-E-RD` | Policy | Corporate Governance & Management System Policy | Resource Definitions (RD) | Planned business document |
| 42 | Enterprise | Enterprise (E) | `PY-E-PC` | Policy | Quality Policy | Production Capability (PC) | Planned business document |
| 43 | Enterprise | Enterprise (E) | `PE-E-RD` | Procedure | Controlled Document & Record Governance Procedure | Resource Definitions (RD) | Planned business document |
| 44 | Enterprise | Enterprise (E) | `PE-E-PP` | Procedure | Internal Audit, Corrective Action & Management Review Procedure | Production Performance (PP) | Planned business document |
| 45 | Enterprise | Enterprise (E) | `PN-E-PC-EN-[short_code]` | Plan | Quality Objectives & Management System Plan | Production Capability (PC) | Planned |
| 46 | Enterprise | CyberSecurity/DataSecurity/Information (C) | `PY-C-RD` | Policy | Information Security & Data Governance Policy | Resource Definitions (RD) | Planned business document |
| 47 | Enterprise | Physical Security & Safety (S) | `PY-S-RD` | Policy | Occupational Health, Safety & Physical Security Policy | Resource Definitions (RD) | Planned business document |

## 3. Site governance additions

Site requirements provide a common local governance baseline without forcing factory-specific documents onto office or warehouse sites.

| # | Trigger | Operation | Code pattern | Type | Template title | ISA-95 pillar | Scope/status |
|---:|---|---|---|---|---|---|---|
| 48 | Site | Enterprise (E) | `PN-E-PC-SI-[short_code]` | Plan | Site Management System & Operational Objectives Plan | Production Capability (PC) | Planned |
| 49 | Site | Physical Security & Safety (S) | `PN-S-RD-SI-[short_code]` | Plan | Site Emergency Response & Evacuation Plan | Resource Definitions (RD) | Planned |
| 50 | Site | Enterprise (E) | `PN-E-RD-SI-[short_code]` | Plan | Site Business Continuity & Recovery Plan | Resource Definitions (RD) | Planned |
| 51 | Site | Physical Security & Safety (S) | `PE-S-RD-SI-[short_code]` | Procedure | Site Access, Visitor & Contractor Control Procedure | Resource Definitions (RD) | Planned |

## 4. Engineering / NPI additions

These candidates add design-controlled and reliability knowledge that is not systematically represented in the original MESA operational catalogue.

| # | Trigger | Operation | Code pattern | Type | Template title | ISA-95 pillar | Scope/status |
|---:|---|---|---|---|---|---|---|
| 52 | NPI & Package Engineering (Area) | Enterprise (E) | `PE-E-PD-AR-[short_code]` | Procedure | New Product Introduction & Engineering Change Control Procedure | Product Definition (PD) | Planned |
| 53 | IC Package & Leadframe Design (WorkCenter) | Enterprise (E) | `PE-E-PD-WC-[short_code]` | Procedure | Package & Leadframe Design Control Procedure | Product Definition (PD) | Planned |
| 54 | IC Package & Leadframe Design (WorkCenter) | Enterprise (E) | `SN-E-PD-WC-[short_code]` | Specification | Package Design & Engineering Specification | Product Definition (PD) | Planned |
| 55 | Failure Analysis & Reliability Testing (WorkCenter) | Quality (Q) | `PE-Q-PP-WC-[short_code]` | Procedure | Failure Analysis & Reliability Investigation Procedure | Production Performance (PP) | Planned |
| 56 | Failure Analysis & Reliability Testing (WorkCenter) | Quality (Q) | `SN-Q-PC-WC-[short_code]` | Specification | Reliability Test & Failure Analysis Specification | Production Capability (PC) | Planned |

## 5. Corporate quality additions

These complement shop-floor quality templates with QMS, customer-quality and metrology governance.

| # | Trigger | Operation | Code pattern | Type | Template title | ISA-95 pillar | Scope/status |
|---:|---|---|---|---|---|---|---|
| 57 | Quality Assurance (Area) | Quality (Q) | `PN-Q-PC-AR-[short_code]` | Plan | Quality Assurance & Audit Program Plan | Production Capability (PC) | Planned |
| 58 | Customer Quality & Audit Management (WorkCenter) | Quality (Q) | `PE-Q-PP-WC-[short_code]` | Procedure | Customer Complaint, Audit & Escalation Procedure | Production Performance (PP) | Planned |
| 59 | Incoming & Outgoing Metrology (WorkCenter) | Quality (Q) | `PE-Q-PC-WC-[short_code]` | Procedure | Measurement, Calibration & Metrology Control Procedure | Production Capability (PC) | Planned |
| 60 | Incoming & Outgoing Metrology (WorkCenter) | Quality (Q) | `SN-Q-PC-WC-[short_code]` | Specification | Measurement & Calibration Acceptance Specification | Production Capability (PC) | Planned |

## 6. Supply chain / planning additions

These connect corporate planning and customer-consigned material accountability to the shared vocabulary.

| # | Trigger | Operation | Code pattern | Type | Template title | ISA-95 pillar | Scope/status |
|---:|---|---|---|---|---|---|---|
| 61 | Supply Chain & Planning (Area) | Enterprise (E) | `PE-E-PS-AR-[short_code]` | Procedure | Supply, Demand & Production Planning Procedure | Production Schedule (PS) | Planned |
| 62 | Master Production Scheduling (WorkCenter) | Production (P) | `PE-P-PS-WC-[short_code]` | Procedure | Master Production Scheduling & Capacity Planning Procedure | Production Schedule (PS) | Planned |
| 63 | Wafer Consignment & Customer Service (WorkCenter) | Inventory (I) | `PE-I-RD-WC-[short_code]` | Procedure | Customer Consignment & Material Accountability Procedure | Resource Definitions (RD) | Planned |

## 7. IT / factory automation additions

These use operation `C` for cyber security, data security and information governance rather than forcing IT/OT knowledge under Production or Maintenance.

| # | Trigger | Operation | Code pattern | Type | Template title | ISA-95 pillar | Scope/status |
|---:|---|---|---|---|---|---|---|
| 64 | IT & Factory Automation (Area) | CyberSecurity/DataSecurity/Information (C) | `PE-C-RD-AR-[short_code]` | Procedure | IT & OT Systems Governance Procedure | Resource Definitions (RD) | Planned |
| 65 | MES / SECS-GEM Systems Integration (WorkCenter) | CyberSecurity/DataSecurity/Information (C) | `SN-C-RD-WC-[short_code]` | Specification | MES / SECS-GEM Integration & Interface Specification | Resource Definitions (RD) | Planned |
| 66 | MES / SECS-GEM Systems Integration (WorkCenter) | CyberSecurity/DataSecurity/Information (C) | `PE-C-PP-WC-[short_code]` | Procedure | MES / Equipment Integration Change & Deployment Procedure | Production Performance (PP) | Planned |
| 67 | Enterprise Infrastructure & Network (WorkCenter) | CyberSecurity/DataSecurity/Information (C) | `SD-C-RD-WC-[short_code]` | Standard | Network, Server & Infrastructure Configuration Standard | Resource Definitions (RD) | Planned |
| 68 | Enterprise Infrastructure & Network (WorkCenter) | CyberSecurity/DataSecurity/Information (C) | `PE-C-RD-WC-[short_code]` | Procedure | Backup, Restore & Infrastructure Recovery Procedure | Resource Definitions (RD) | Planned |

## 8. Finance / procurement additions

Only manufacturing-relevant procurement and cost controls are included. Payroll, tax, treasury and general accounting documents remain outside this MESA-adjacent catalogue.

| # | Trigger | Operation | Code pattern | Type | Template title | ISA-95 pillar | Scope/status |
|---:|---|---|---|---|---|---|---|
| 69 | Cost Accounting & Material Purchasing (WorkCenter) | Enterprise (E) | `PE-E-RD-WC-[short_code]` | Procedure | Purchasing, Supplier Approval & Material Procurement Procedure | Resource Definitions (RD) | Planned |
| 70 | Cost Accounting & Material Purchasing (WorkCenter) | Enterprise (E) | `PE-E-PP-WC-[short_code]` | Procedure | Manufacturing Cost & Material Variance Control Procedure | Production Performance (PP) | Planned |

## 9. HR / EHS / facilities additions

These add cross-site competence, safe-work, emergency-preparedness and contractor/facilities governance.

| # | Trigger | Operation | Code pattern | Type | Template title | ISA-95 pillar | Scope/status |
|---:|---|---|---|---|---|---|---|
| 71 | HR / EHS / Facilities (Area) | Enterprise (E) | `PE-E-PC-AR-[short_code]` | Procedure | Competence, Training & Qualification Management Procedure | Production Capability (PC) | Planned |
| 72 | HR / EHS / Facilities (Area) | Physical Security & Safety (S) | `PE-S-RD-AR-[short_code]` | Procedure | EHS Risk Assessment & Safe Work Control Procedure | Resource Definitions (RD) | Planned |
| 73 | HR / EHS / Facilities (Area) | Physical Security & Safety (S) | `PN-S-RD-AR-[short_code]` | Plan | Occupational Safety & Emergency Preparedness Plan | Resource Definitions (RD) | Planned |
| 74 | HR / EHS / Facilities (Area) | Enterprise (E) | `PE-E-RD-AR-[short_code]` | Procedure | Facilities & Contractor Management Procedure | Resource Definitions (RD) | Planned |

## Applicability and provisioning rules

1. **A catalogue row is a candidate, not an automatic mandate.** Enable a requirement rule only after the responsible domain owner approves its trigger, applicability conditions and watched attributes.
2. **Business documents are not multiplied per entity.** Rows whose codes omit `[Model]-[short_code]` represent enterprise-wide controlled knowledge. The Enterprise record may trigger the requirement, but the resulting document remains business-scoped.
3. **Entity documents resolve one actual source model.** For rows 9–12, choose `WC` or `WU` from the source entity; never use an ambiguous WorkStation alias in a final document code.
4. **Requirement and document lifecycles are separate.** A governed knowledge requirement can be unsatisfied while no controlled document exists; authoring, review, approval and revision then occur in the knowledge domain.
5. **Avoid blanket provisioning.** Use hierarchy, equipment/asset, process and personnel associations as permitted requirement bases, with documented applicability criteria.
6. **Sequence allocation is stable and atomic.** Use a suffix such as `-001` only when another document would otherwise share the same classification and entity code; never renumber or reuse an allocated sequence.
7. **Validate source identifiers before cutover.** Each source used in a document code must expose the registered immutable identifier and satisfy the model-specific length and character rules.

## Revision notes

- Reordered every existing MESA pattern from model-first to classification-first.
- Aligned existing rows 8, 18, 19, 24 and 35 with the revised controlled-document matrix, including their corrected document types, pillars and titles.
- Preserved the existing 40 relative template-file references; file renaming and template-content migration are separate implementation tasks.
- Added `EN`, `SI` and `AR` as proposed hierarchy-model codes, subject to registration.
- Added 34 candidate templates covering Enterprise, Site, Corporate, Engineering, Quality, Supply Chain, IT/OT, Finance/Procurement and HR/EHS/Facilities scope.
- Distinguished business-scoped governance documents from entity-scoped operational documents.
