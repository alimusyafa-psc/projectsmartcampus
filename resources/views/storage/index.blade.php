@extends('layouts.master')

@section('content')
<div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Storage Raspberry Pi</h6>
                </div>
                <div class="col-lg-6 col-5 my-auto text-end">
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Raspberry Pi</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Storage</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Storage Used</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Percentage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="xd">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Raspberry 1 (Mahasiswa)</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold">{{ $totalSpaceGB1 }} GB </span>                      
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold">{{ $targetFolderSize1 }} </span>                      
                      </td>
                      <td class="align-middle">
                        <div class="progress-wrapper w-75 mx-auto">
                          <div class="progress-info">
                            <div class="progress-percentage">
                              <span class="text-xs font-weight-bold"> {{ $percentageUsed1 }} </span>
                            </div>
                          </div>
                          <div class="progress">
                            <div class="progress-bar bg-gradient-info w-60" role="progressbar" aria-valuenow="{{ $percentageUsed1 }}" aria-valuemin="0" aria-valuemax="100%">
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="xd">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Raspberry 2 (Tamu)</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold">{{ $totalSpaceGB2 }} GB </span>                      
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold">{{ $targetFolderSize2 }} </span>                      
                      </td>
                      <td class="align-middle">
                        <div class="progress-wrapper w-75 mx-auto">
                          <div class="progress-info">
                            <div class="progress-percentage">
                              <span class="text-xs font-weight-bold"> {{ $percentageUsed2 }} </span>
                            </div>
                          </div>
                          <div class="progress">
                            <div class="progress-bar bg-gradient-info w-60" role="progressbar" aria-valuenow="{{ $percentageUsed2 }}" aria-valuemin="0" aria-valuemax="100%">
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
@endsection