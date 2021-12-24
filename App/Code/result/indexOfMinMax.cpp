#include <iostream>
#include <vector>
#include <algorithm>
using namespace std;
std::vector<int> indexOfMinMax(std::vector<int> arr)
{
    vector<int> v=arr;
    sort(arr.begin(),arr.end());
    int max = arr[arr.size()-1],min=arr[0];
    int i=0,j=0;
    while(true){
      if(v[i]==min)
        break;
      else i++;
     }
    while(true){
      if(v[j]==max)
        break;
      else j++;
     }
     return {i,j};
}
int main()
{
    int n;
    cin >> n;
    vector<int> arr;
    for(int i =0; i < n; ++i)
    {
        int num;
        cin >> num;
        arr.push_back(num);
    }
    vector<int> result;
    result = indexOfMinMax(arr);
    cout << result[0] << " " << result[1];
}