import { GradleadPage } from './app.po';

describe('gradlead App', function() {
  let page: GradleadPage;

  beforeEach(() => {
    page = new GradleadPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
